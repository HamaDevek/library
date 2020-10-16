<?php

use Illuminate\Support\Facades\Route;



Auth::routes();
Route::get('/', function () 
{
    return redirect(route('student.index'));
})->name('index');

Route::middleware(['auth'])->group(
    function () {
        Route::resource('student', 'StudentController');
        Route::resource('department', 'DepartmentController');
        Route::resource('book', 'BookController');
        Route::get('resrvation/books/{student}', 'ResrvationController@books')->name('resrvation.books');
        Route::resource('resrvation', 'ResrvationController');
    }
);
