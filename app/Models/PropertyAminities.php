<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAminities extends Model
{
    protected $table ='property_aminites';

    protected $fillable =[
        'aminities_id',
        'property_id',
        'is_active',
    ];

    public function aminities()
{
    return $this->belongsTo(Aminites::class, 'aminites_id');
}
}
