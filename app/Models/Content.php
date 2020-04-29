<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    protected $fillable = [
        'parent_id',
        'display_in',
        'title',
        'slug',
        'image',
        'short_desc',
        'description',
        'display_order',
        'status',
        'is_active',
        'created_by',
        'edit',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Content', 'parent_id')->where('is_active','1')->where('header','1');
    }

    public function allChild()
    {
        return $this->hasMany('App\Models\Content', 'parent_id')->with('child');
    }

    public function child()
    {
        return $this->hasMany(Content::class, 'parent_id')->where('is_active','1')->where('header','1');
    }

    public function getCreatedAt()
    {
        return $this->created_at->toFormattedDateString();
    }

    public function getUpdatedAt()
    {
        return $this->updated_at->toFormattedDateString();
    }

    public function getParentTitle()
    {
        return $this->parent ? $this->parent->title : "";
    }
}
