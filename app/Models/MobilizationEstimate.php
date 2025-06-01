<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobilizationEstimate extends Model
{
    protected $fillable = [
        'user_id',
        'mobilization_activity_id',
        'mobilization_goal',
        'estimated_count',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mobilizationActivity(): BelongsTo
    {
        return $this->belongsTo(MobilizationActivity::class);
    }

    public function hasGoal(): bool
    {
        return !is_null($this->mobilization_goal);
    }
} 