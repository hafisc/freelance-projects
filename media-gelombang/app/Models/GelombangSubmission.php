<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GelombangSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'latihan_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
