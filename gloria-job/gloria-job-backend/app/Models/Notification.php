<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'title', 'message', 'is_read'])]
class Notification extends Model
{
    use HasFactory;

    // Relasi ke User / Pencari Kerja yang menerima notifikasi ini
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
