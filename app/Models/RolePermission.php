<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{


    protected $table= 'rolepermission';

    protected $fillable = ['permission_id','role_id'];


    public function role(){

        return $this->belongsTo(Role::class,'role_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class,'permission_id');
    }
}
