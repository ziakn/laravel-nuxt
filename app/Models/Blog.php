<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Blog extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id' ,'id');
    }

}
