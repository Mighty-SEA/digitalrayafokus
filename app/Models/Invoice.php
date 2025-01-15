<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];
    use HasFactory;

    protected $dates = [
        'invoice_date',
        'due_date',
        'created_at',
        'updated_at'
    ];

    public function Item(){
        return $this->hasMany(Item::class);
    }

    public function Customer(){
        return $this->belongsTo(Customer::class);
    }
}
