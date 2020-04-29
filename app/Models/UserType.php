<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table ='usertype';

    protected $fillable = [
      'name',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->hasOne(User::class,'usertype_id');
    }
}
