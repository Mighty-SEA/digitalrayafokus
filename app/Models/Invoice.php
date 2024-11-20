<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function Item(){
        return $this->belongsTo(Item::class);
    }

    public function Customer(){
        return $this->hasMany(Customer::class);
    }
}
