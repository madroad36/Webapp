<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table='service_order';

    protected $fillable =[

        'technician_id',
        'paid',
        'request_id',
        'start',
        'end',
        'location',
        'contact',
        'date',
        'description',
        'duration',
        'count',
        'is_active',
        'finished',
        'amount'

    ];
    public function technician(){
        return $this->belongsTo(User::class,'technician_id');
    }
    public function WorkingHour(){
        return $this->hasMany(WorkingHour::class,'request_id');
    }
    public function service(){
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }
    public function active(){
        return $this->WorkingHour()->where('is_active','=', 1);
    }
    public function deactive(){
        return $this->WorkingHour()->where('is_active','=', 0);
    }
    public function serviceRequest(){
        return $this->belongsTo(ServiceRequest::class,'request_id');
    }

}
