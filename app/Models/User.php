<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['nombre', 'email', 'password', 'rol'];

    public $timestamps = false;
}
