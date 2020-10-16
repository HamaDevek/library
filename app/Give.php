<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Give extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'g_admin');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'g_student');
    }
    public function book()
    {
        return $this->belongsTo(Book::class, 'g_book');
    }
}
