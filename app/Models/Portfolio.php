<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    protected $fillable = [
        'image',
        'image2',
        'image3',
        'title',
        'description',
        'category',
        'year',
        'link'
    ];

    // Accessor untuk gambar
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function getImage2UrlAttribute()
    {
        return $this->image2 ? Storage::url($this->image2) : null;
    }

    public function getImage3UrlAttribute()
    {
        return $this->image3 ? Storage::url($this->image3) : null;
    }
} 