<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
	protected $table ='sliders';

	protected $fillable =[
		'image',
		'status',
		'section',
		'created_by'
	];

	public  function user(){
		return $this->belongsTo(User::class,'created_by');
	}
}
