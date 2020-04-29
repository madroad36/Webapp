<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificate_image';

    protected $fillable =[
        'user_id',
        'image'
    ];
}
