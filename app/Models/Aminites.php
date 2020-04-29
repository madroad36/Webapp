<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Aminites extends Model
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

    protected $table ='aminites';

    protected $fillable =[
        'name',
        'is_active',
        'created_by',
        'slug'
    ];
    public  function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function property(){
        return $this->belongsTo(Property::class,'property_aminites','zminities_id');
    }
}
