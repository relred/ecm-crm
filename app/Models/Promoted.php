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

}
