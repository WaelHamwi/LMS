<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
    use HasFactory;


    protected $fillable = ['key', 'value'];


    public static function getSetting($key, $default = null)
    {
        return self::where('key', $key)->first()->value ?? $default;
    }

    public static function setSetting($key, $value)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        return $setting;
    }
}
