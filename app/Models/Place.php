<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use Sluggable;

    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    protected $table ='place';

    protected $fillable=[
      'name',
      'slug',
      'location_id',
      'created_by'
    ];

    public  function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function location(){
        return $this->belongsTo(Location::class,'location_id');
    }
}
