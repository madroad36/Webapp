<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Source;

class Role extends Model
{

    use Sluggable;

    public function sluggable()
    {
        return [
          'slug'=>[
              'source' => 'name'
          ]
        ];
    }

    protected $table = 'roles';

    protected $fillable = ['name','slug','created_by'];


    public function Permission(){


        return $this->belongsToMany(Permission::class,'rolepermission');
    }
}
