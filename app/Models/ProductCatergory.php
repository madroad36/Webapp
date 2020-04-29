<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ProductCatergory extends Model
{
    use Sluggable;

    public  function sluggable()
    {
        return [
            'slug'=>[
                'source' => 'title'
            ]

        ];
    }

    protected $table = 'product_category';


    protected $fillable =[
        'title',
        'is_active',
        'created_by',
        'slug',
    ];
    public  function user(){
        return $this->belongsTo(User::class,'created_by');
    }
}
