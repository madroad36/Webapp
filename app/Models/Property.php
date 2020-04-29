<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $table = 'property';

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'sold',
        'is_active',
        'created_by',
        'location_id',
        'category_id',
        'subcategory_id',
        'overview',
        'price',
        'feature',
        'broker',
        'near_by',
        'review',
        'service_charge',
        'property_image',
        'area',
        'plot_no',
        'broker_id',
        'paid',
        'slug',
        'place_id',
        'name',
        'contact',
        'citizen',
        'owner_image',
        'ammenities',
        'face',
        'shape',
        'road_size',
        'direction',
        'parking',
        'house_type',
        'drainage',
        'build',
        'total_room',
        'kitchen',
        'store',
        'bathroom',
        'living_room',
        'hall',
        'date_type',
        'rent_option',
        'land_unit',
        'property_paper'


    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategories::class, 'subcategory_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function brokers()
    {
        return $this->belongsTo(User::class, 'broker_id');
    }



    public function image()
    {
        return $this->hasMany(PropertyImage::class, 'property_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }

    public function property_amminites(){
        return $this->hasMany(PropertyAminities::class ,'property_id');
    }
    public function aminites(){


        return $this->belongsToMany(Aminites::class,'property_aminites','property_id','aminities_id');

//        return $this->hasManyThrough(PropertyAminities::class ,Aminites::class,Property::class);
    }

    public function book(){
        return $this->hasMany(Booking::class,'property_id');
    }


}
