<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{

    protected $table='subcategories';

    protected $fillable=[
      'title',
      'category_id',
        'is_active'
    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
