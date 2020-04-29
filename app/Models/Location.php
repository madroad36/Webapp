<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table ='location';

    protected $fillable =[
      'name',
      'is_active',
      'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
