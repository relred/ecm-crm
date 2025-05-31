<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialSupporter extends Model
{
    protected $fillable = [
        'name',
        'state',
        'municipality',
        'mobilized_goal',
        'current_mobilized',
        'registration_token',
        'is_registered',
    ];

    protected $casts = [
        'is_registered' => 'boolean',
        'mobilized_goal' => 'integer',
        'current_mobilized' => 'integer',
    ];
} 