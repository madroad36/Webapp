<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table='vendor';

    protected $fillable=[
        'name',
        'pan_vat',
        'pan_vat_image',
        'location',
        'is_active',
        'vendor_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'vendor_id');
    }
}
