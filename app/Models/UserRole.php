<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $table = 'roleuser';

    protected $fillable =[
      'role_id',
      'user_id'
    ];

    public function Role(){
        return $this->belongsTo(Role::class,'role_id');
    }
}
