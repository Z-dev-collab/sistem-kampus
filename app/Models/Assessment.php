<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'user_id', 'assessor_id', 'period_id',
        'soft_skill_score', 'hard_skill_score',
        'discipline_score', 'attitude_score',
        'total_score', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'soft_skill_score' => 'decimal:2',
            'hard_skill_score' => 'decimal:2',
            'discipline_score' => 'decimal:2',
            'attitude_score' => 'decimal:2',
            'total_score' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Calculate weighted total score
     * Soft Skill: 25%, Hard Skill: 35%, Discipline: 20%, Attitude: 20%
     */
    public function calculateTotal(): float
    {
        $this->total_score = round(
            ($this->soft_skill_score * 0.25) +
            ($this->hard_skill_score * 0.35) +
            ($this->discipline_score * 0.20) +
            ($this->attitude_score * 0.20),
            2
        );
        return $this->total_score;
    }
}
