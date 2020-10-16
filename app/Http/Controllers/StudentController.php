<?php

namespace App\Http\Controllers;

use App\Department;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Department::where('d_state',1)->get();
        $data = Student::with(['department','admin'])->get();
        return view('pages.student',['department'=>$department,'data'=>$data]);
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
            'phone' => 'required|string|max:17|unique:students,s_phone',
            'email' => 'required|string|email|max:255|unique:students,s_email',
            'department' => 'required|exists:departments,id',
        ]);
        $student = new Student;
        $student->s_name = $request->name;
        $student->s_phone = $request->phone;
        $student->s_email = $request->email;
        $student->s_admin = auth()->user()->id;
        $student->s_department = $request->department;
        $student->save();
        return redirect()->back()->withSuccess('Added Student Successfully !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:17|unique:students,s_phone,'. $student->id,
            'email' => 'required|string|email|max:255|unique:students,s_email,'. $student->id,
            'department' => 'required|exists:departments,id',
        ]);
        $student->s_name = $request->name;
        $student->s_phone = $request->phone;
        $student->s_email = $request->email;
        $student->s_admin = auth()->user()->id;
        $student->s_department = $request->department;
        $student->save();
        return redirect()->back()->withSuccess('Updated Student Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return redirect()->back()->withSuccess('Deleted Student Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Maybe has relation !');
        }
    }
}
