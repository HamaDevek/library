<?php

namespace App\Http\Controllers;

use App\Book;
use App\Department;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Department::where('d_state',1)->get();
        $data = Book::with(['admin','department'])->get();
        return view('pages.book ',['data'=>$data,'department'=>$department]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|gt:0',
            'department' => 'required|exists:departments,id',
            'state' => 'sometimes|in:on,null',
        ]);
        $book = new Book();
        $book->b_name = $request->name;
        $book->b_amount = $request->amount;
        $book->b_department = $request->department;
        $book->b_state =  $request->state == 'on' ? 1 : 0;
        $book->b_admin = auth()->user()->id;
        $book->save();
        return redirect()->back()->withSuccess('Added Book Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $book->b_state = !$book->b_state ;
        $book->save();
        return redirect()->back()->withSuccess('Updated Book Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|gt:0',
            'department' => 'required|exists:departments,id',
            'state' => 'sometimes|in:on,null',
        ]);
        $book->b_name = $request->name;
        $book->b_amount = $request->amount;
        $book->b_department = $request->department;
        $book->b_state =  $request->state == 'on' ? 1 : 0;
        $book->b_admin = auth()->user()->id;
        $book->save();
        return redirect()->back()->withSuccess('Updated Book Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        try {
            $book->delete();
            return redirect()->back()->withSuccess('Deleted Book Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Maybe has relation !');
        }
    }
}
