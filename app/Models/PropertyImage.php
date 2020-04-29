<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table='property_image';
    protected $fillable =[
        'property_id',
        'image'
    ];



}
