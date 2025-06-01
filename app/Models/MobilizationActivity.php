<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MobilizationActivity extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'state',
        'municipality',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function estimates(): HasMany
    {
        return $this->hasMany(MobilizationEstimate::class);
    }

    public function latestEstimate()
    {
        return $this->hasOne(MobilizationEstimate::class)->latestOfMany();
    }
} 