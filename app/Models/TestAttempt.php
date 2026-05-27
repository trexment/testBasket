<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_questions',
        'correct_answers',
        'score_percentage',
        'category_type',
        'difficulty_filter',
        'time_limit_seconds',
        'duration_seconds',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(TestAnswer::class);
    }

    public function getScorePercentageAttribute($value)
    {
        return round($value, 2);
    }
}
