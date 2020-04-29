<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug'=>[
                'source'=>'name'
            ]
        ];
    }

    protected $table ='service_category';

    protected $fillable =[
        'name',
        'is_active',
        'created_by',
        'slug',
        'image'
    ];

    public  function user(){
        return $this->belongsTo(User::class,'created_by');
    }


}
