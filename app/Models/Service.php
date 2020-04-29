<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Sluggable;


    public  function sluggable()
    {
        return [
            'slug'=>[
                'source' => 'title'
            ]

        ];
    }

    protected $table='services';
    protected $fillable =[
        'title',
        'description',
        'thumbnail',
        'is_active',
        'created_by',
        'slug',
        'category_id',
        'location_id',
        'place_id',
        'subcategory_id',
        'monthly',
        'task',
        'member',
        'yearly',
        'hourly',
        'rate',
        'rate_type'
    ];

    public  function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function category(){
        return $this->belongsTo(ServiceCategory::class,'category_id');
    }
    public function location(){
        return $this->belongsTo(Location::class,'location_id');
    }

    public function place(){
        return $this->belongsTo(Place::class, 'place_id');
    }
    public  function subcategory(){
        return $this->belongsTo(ServiceSubcategory::class,'subcategory_id');
    }

    public function serviceOrder(){
        return $this->hasManyThrough('App\Models\ServiceRequest','App\Models\ServiceOrder');
    }

   public function serviceRequest(){
        return $this->belongsTo(ServiceRequest::class, 'service_id');
   }

}
