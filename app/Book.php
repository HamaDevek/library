<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'b_admin');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'b_department');
    }
}
