<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $guarded = ['id'];

    // Helper method to get setting value
    public static function get($key)
    {
        return static::where('key', $key)->value('value');
    }

    // Helper method to set setting value
    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
