<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageFolder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['deleted_at'];
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeNoRoot($query)
    {
        return $query->where('id','!=', 1);
    }
}
