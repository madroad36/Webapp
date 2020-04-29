<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPassword extends Model
{

    public $timestamps = false;

    protected $table = 'password_resets';

    protected $fillable = ['email','token','created_at'];
}
