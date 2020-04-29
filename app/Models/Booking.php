<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{


    protected $table ='booking';


    protected $fillable =[
        'buyer_id',
        'property_id',
        'is_active'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function property(){
        return $this->belongsTo(Property::class,'property_id');
    }
}
