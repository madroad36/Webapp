<?php

namespace App\Models;

use bar\baz\source_with_namespace;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable;

    public function sluggable(){

        return [
            'slug'=>[
                'source'=>'title'
            ]
        ];
    }
    protected $table='product';
    protected $fillable =[
        'title',
        'description',
        'image',
        'is_active',
        'created_by',
        'slug',
        'category_id',
        'price',
        'paid',
        'quantity',
        'unit'

    ];
    public function category(){
        return $this->belongsTo(ProductCatergory::class,'category_id');
    }
    public  function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function images(){
        return $this->hasMany(ProductImage::class,'product_id');
    }
}
