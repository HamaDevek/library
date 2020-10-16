<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'd_admin');
    }
}
