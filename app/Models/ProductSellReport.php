<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSellReport extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table ='product_sells_record';

    protected $fillable =[
        'owner_id',
        'product_id',
        'buyer_id',
        'quantity',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'location',
        'serial_number'

    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id');
    }
}
