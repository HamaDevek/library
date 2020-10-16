<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Department::get();
        return view('pages.department',['data'=>$data]);

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
            'state' => 'sometimes|in:on,null',

        ]);
        $department = new Department;
        $department->d_name = $request->name;
        $department->d_state =  $request->state == 'on' ? 1 : 0;
        $department->d_admin = auth()->user()->id;
        $department->save();
        return redirect()->back()->withSuccess('Added Department Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $department->d_state = !$department->d_state ;
        $department->save();
        return redirect()->back()->withSuccess('Updated Department Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
        ]);
        $department->d_name = $request->name;
        $department->d_state =  $request->state == 'on' ? 1 : 0;
        $department->d_admin = auth()->user()->id;
        $department->save();
        return redirect()->back()->withSuccess('Updated Department Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {
            $department->delete();
            return redirect()->back()->withSuccess('Deleted Department Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Maybe has relation !');
        }
    }
}
