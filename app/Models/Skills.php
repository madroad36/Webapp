<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    protected $table ='skills';

    protected $fillable =[
      'subcategory_id',
      'description',
        'user_id'

    ];

    public  function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
