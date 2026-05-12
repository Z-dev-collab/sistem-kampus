<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'photo',
        'nisn', 'kelas', 'jurusan', 'nip', 'jabatan',
        'industry_id', 'guru_pembimbing_id', 'pembimbing_industri_id',
        'period_id', 'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ── Role Helpers ──
    public function isSiswa(): bool { return $this->role === 'siswa'; }
    public function isPembimbingIndustri(): bool { return $this->role === 'pembimbing_industri'; }
    public function isGuruPembimbing(): bool { return $this->role === 'guru_pembimbing'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }

    // ── Relationships ──
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function guruPembimbing()
    {
        return $this->belongsTo(User::class, 'guru_pembimbing_id');
    }

    public function pembimbingIndustri()
    {
        return $this->belongsTo(User::class, 'pembimbing_industri_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    // Students supervised by this pembimbing industri
    public function supervisedStudents()
    {
        return $this->hasMany(User::class, 'pembimbing_industri_id');
    }

    // Students guided by this guru pembimbing
    public function guidedStudents()
    {
        return $this->hasMany(User::class, 'guru_pembimbing_id');
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D9488&color=fff&size=128';
    }
}
