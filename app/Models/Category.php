<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    protected $table ='category';

    protected $fillable =[
        'name',
        'is_active',
        'created_by',
        'slug'
    ];

    public  function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    public  function property(){
        return $this->hasMany(Property::class,'category_id');
    }

    public function propertylist(){
        return $this->property()->where('is_active','1')->where('sold','!=','1')->latest()->take(8);
    }
}
