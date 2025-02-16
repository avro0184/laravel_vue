<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'Teacher';
    protected $fillable = ['name', 'email', 'phone', 'address'];
}
