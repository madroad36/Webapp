<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $table ='working_hour';

    protected  $fillable =[
      'request_id',
      'start',
      'end',
      'duration',
      'created_at',
      'updated_at',
        'is_active',
        'amount'
    ];
}
