<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = [
        'date', 'city', 'weather_id', 'main', 'description', 'icon'
    ];
}
