<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded =[];
    use HasFactory;

    public function Invoice() {
        return $this->hasMany(Invoice::class);
    }
}
