<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotedImport extends Model
{
    protected $guarded = ['id'];

    protected $dates = ['cancelled_at'];

    public function isCancelled()
    {
        return $this->cancelled_at !== null;
    }

    public function promoted()
    {
        return $this->hasMany(Promoted::class, 'import_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function promoter()
    {
        return $this->belongsTo(User::class, 'promoter_id');
    }

}
