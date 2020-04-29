<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSubcategory extends Model
{
    use SoftDeletes;

    use Sluggable;

    public function sluggable()
    {
        return [
            'slug'=>[
                'source'=>'title'
            ]
        ];
    }

    protected $table ='service_subcategory';

    protected $fillable =[
      'title',
      'is_active',
        'category_id',
        'image',
        'slug'

    ];

    public  function category(){
        return $this->belongsTo(ServiceCategory::class,'category_id');
    }
}
