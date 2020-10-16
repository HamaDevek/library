<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 's_admin');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 's_department');
    }
}
