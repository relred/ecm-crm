<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Promoted extends Model
{
    protected $table = 'promoted';
    protected $guarded = ['id'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contactTouches()
    {
        return $this->hasMany(Touch::class);
    }

    public function latestTouch()
    {
        return $this->hasOne(Touch::class)->latestOfMany('touch_number');
    }

    public function getNeedsTransportStatus(): string|null
    {
        return $this->needs_transport;
    }

    public function currentTouch(): int
    {
        return $this->contactTouches()->count();
    }

    public function import()
    {
        return $this->belongsTo(PromotedImport::class, 'import_id');
    }
}
