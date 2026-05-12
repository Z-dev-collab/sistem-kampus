<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['user_id', 'date', 'description', 'competency_category', 'status'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(JournalPhoto::class);
    }

    public function comments()
    {
        return $this->hasMany(JournalComment::class)->latest();
    }

    public function scopeDraft($query) { return $query->where('status', 'draft'); }
    public function scopeMenunggu($query) { return $query->where('status', 'menunggu'); }
    public function scopeRevisi($query) { return $query->where('status', 'revisi'); }
    public function scopeTerverifikasi($query) { return $query->where('status', 'terverifikasi'); }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'draft' => 'badge-draft',
            'menunggu' => 'badge-warning',
            'revisi' => 'badge-danger',
            'terverifikasi' => 'badge-success',
            default => 'badge-secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'menunggu' => 'Menunggu Validasi',
            'revisi' => 'Perlu Revisi',
            'terverifikasi' => 'Terverifikasi',
            default => $this->status,
        };
    }
}
