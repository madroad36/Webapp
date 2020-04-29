<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype_id',
        'created_by',
        'is_active',
        'batch_number',
        'image',
        'id_card',
        'contact',
        'address',
        'description',
        'backend',
        'broker',
        'vendor',
        'service'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userType(){
        return $this->belongsTo(UserType::class,'usertype_id');
    }
    public function admin(){
        return $this->belongsTo(UserType::class,'usertype_id');
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'roleuser');
    }

//    public function UserRoles(){
//
//        return $this->hasMany(UserRole::class ,'user_id');
//    }
    public function UserRoles(){
        return $this->belongsToMany(Role::class,'roleuser');
    }

    public  function property(){
        return $this->belongsToMany(Property::class,'user_id');
    }
    public  function brokerList(){
        return $this->hasMany(Property::class,'broker_id');
    }

    public function owner(){
        return $this->hasMany(Property::class,'created_by');
    }
    public function skill(){
        return $this->belongsTo(Skills::class,'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id');
    }
    public function order(){

        return $this->hasMany(Booking::class,'buyer_id');
    }
    public function technician(){
        return $this->hasOne(Technician::class,'technician_id');
    }
    public function vendors(){
        return $this->hasOne(Vendor::class,'vendor_id');
    }
    public function brokers(){
        return $this->hasOne(Broker::class,'broker_id');
    } 
}
