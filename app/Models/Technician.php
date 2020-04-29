<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $table='technician';

    protected $fillable=[
        'category_id',
        'experience',
        'citizen',
        'citizen_no',
        'certificate',
        'is_active',
        'technician_id'
    ];

    public function category(){
        return $this->belongsTo(ServiceCategory::class,'category_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'technician_id')->orderBy('name');
    }
}
