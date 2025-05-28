<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Touch extends Model
{
    protected $guarded = [
        'id',
    ];

    public function promoted()
    {
        return $this->belongsTo(Promoted::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
