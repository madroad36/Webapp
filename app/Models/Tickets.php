<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{

    protected $table ='ticket';

    protected $fillable =[
        'servicerequest_id',
        'created_by',
        'update_by',
        'is_active',
        'ticket',
    ];
//
    public function technician(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function owner(){
        return $this->belongsTo(User::class,'update_by');
    }
}
