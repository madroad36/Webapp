<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{


    use Sluggable;


    public  function sluggable()
    {
        return [
            'slug'=>[
                'source' => 'name'
            ]

        ];
    }

    protected $table = 'permission';

    protected $fillable = ['name','slug','created_by'];
}
