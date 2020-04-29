<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    public $timestamps = true;
    protected $table='service_request';

    protected $fillable =[
      'order_by',
      'technician_id',
      'task',
      'hourly',
      'monthly',
      'yearly',
      'place_id',
        'location_id',
        'total_amount',
        'is_active',
        'paid',
        'service_id',
        'start',
        'end',
        'location',
        'contact',
        'pereffered_date',
        'description',
        'duration',
        'count',
        'token',
        'updated_at',
        'created_at'
    ];

    public function owner(){
        return $this->belongsTo(User::class,'order_by');
    }
    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }
    public function technician(){
        return $this->belongsTo(User::class,'technician_id');
    }
    public function location(){
        return $this->belongsTo(Location::class,'location_id');
    }
    public function place(){
        return $this->belongsTo(Place::class,'place_id');
    }

    public function skill(){
        return $this->belongsTo(Skills::class,  'technician_id','user_id');
    }

    public function certificate(){
        return $this->belongsToMany(Certificate::class,  'technician_id','user_id');
    }

   public  function order(){
        return $this->hasMany(ServiceOrder::class,'request_id');
   }

   public function active(){
        return $this->order()->where('is_active','1');
   }




}
