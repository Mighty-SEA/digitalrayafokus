<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanans';

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'description',
        'features',
        'benefits',
        'is_active',
        'order'
    ];

    protected $casts = [
        'features' => 'array',
        'benefits' => 'array',
        'is_active' => 'boolean'
    ];

    // Tambahkan mutator untuk memastikan slug selalu terisi
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($layanan) {
            if (! $layanan->slug) {
                $layanan->slug = Str::slug($layanan->title);
            }
        });
    }
} 