<?php

namespace App\Models;

// use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table='setting';
    protected $fillable =[
        'company','image','address','contact','email','description','website','created_by'
    ];

    public  function user(){
        return $this->belongsTo(User::class,'created_by');
    }
}
