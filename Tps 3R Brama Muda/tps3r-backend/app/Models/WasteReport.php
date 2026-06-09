<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteReport extends Model
{
    protected $fillable = ['user_id', 'photo_path', 'location', 'category', 'description', 'status'];

    protected $appends = ['photo_url'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }
        return null;
    }
}