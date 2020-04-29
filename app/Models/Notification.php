<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends Model
{


    use SoftDeletes;

    protected $table ='notification';

    protected $fillable =[

      'receiver_id',
        'is_active',
        'icon',
        'link',
        'sells',
        'message',


    ];

    public function user (){
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
