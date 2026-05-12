<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalPhoto extends Model
{
    protected $fillable = ['journal_id', 'photo_path', 'caption'];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        return asset('storage/' . $this->photo_path);
    }
}
