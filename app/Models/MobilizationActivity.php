<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
} 