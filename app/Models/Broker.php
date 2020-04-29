<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    protected $table='broker';

    protected $fillable=[
        'service',
        'experience',
        'citizen',
        'citizen_no',
        'certificate',
        'is_active',
        'broker_id'
    ];


    public  function user(){
        return $this->belongsTo(User::class,'broker_id');
    }
}
