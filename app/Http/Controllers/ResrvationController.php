<?php

namespace App\Http\Controllers;

use App\Book;
use App\Give;
use App\Student;
use Carbon\Carbon;
use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;

class ResrvationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Give::with(['admin', 'student', 'book'])->orderBy('g_state')->get();
        return view('pages.resrvation', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Give::with(['admin', 'student', 'book'])->where('g_state',0)->whereDate('g_expire','<',Carbon::today())->get();
        return view('pages.resrvation', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = Book::findOrFail($request->book);

        $request->validate([
            'amount' => 'required|numeric|gt:0|lte:' . $book->b_amount,
            'price' => 'required|numeric|gte:0',
            'book' => 'required|exists:books,id',
            'student' => 'required|exists:students,id',
            'date' => 'required|date|after:tomorrow'
        ]);
        $resrvation = new Give;
        $resrvation->g_price = $request->price;
        $resrvation->g_expire = $request->date;
        $resrvation->g_amount = $request->amount;
        $resrvation->g_book = $request->book;
        $resrvation->g_student = $request->student;
        $resrvation->g_admin = auth()->user()->id;
        $resrvation->save();
        $book->b_amount = $book->b_amount - $request->amount;
        $book->save();
        return redirect()->back()->withSuccess('Gave Book to the student Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        $data = Book::where('b_state', 1)->where('b_amount', '>', 0)->get();
        return view('pages.bookadd', ['data' => $data, 'student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $give = Give::findOrFail($id);
        if (!$give->g_state) {
            $give->g_state = !$give->g_state;
            $give->g_back = date("Y-m-d H:i:s");
            $give->save();
            if ($give->g_state) {
                $book = Book::findOrFail($give->g_book);
                $book->b_amount = $book->b_amount + $give->g_amount;
                $book->save();
            }
        return redirect()->back()->withSuccess('Updated Resrvation Successfully !');

        }
        return redirect()->back()->withErrors('You can not do that !');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $give = Give::findOrFail($id);
        try {
            $book = Book::findOrFail($give->g_book);
            $book->b_amount = $book->b_amount + $give->g_amount;
            $book->save();
            $give->delete();
            return redirect()->back()->withSuccess('Deleted Resrvation Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Maybe has relation !');
        }
    }
   
}
