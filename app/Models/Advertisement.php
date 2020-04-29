<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
	use Sluggable;

	public function sluggable()
	{ 
		return [
			'slug'=>[
				'source'=>'name'
			]
		];
	}

	protected $table ='advertisements';

	protected $fillable =[
		'name',
		'slug',
		'contact',
		'image',
		'start_date',
		'end_date',
		'price',
		'status',
		'index',
		'created_by'
	];
	public  function user(){
		return $this->belongsTo(User::class,'created_by');
	}

}
