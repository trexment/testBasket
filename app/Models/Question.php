<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'category',
        'difficulty',
        'reference',
        'question_code',
        'applicable_roles',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'applicable_roles' => 'array',
    ];

    public function attempts()
    {
        return $this->hasMany(TestAnswer::class);
    }

    public static function getRandomQuestions($count, $category = null, $difficulty = null, $userType = null, $difficulties = null)
    {
        $query = self::where('is_active', true);

        // Filter by user_type using applicable_roles JSON
        if ($userType) {
            $query->where(function ($q) use ($userType) {
                $q->whereRaw("JSON_CONTAINS(applicable_roles, JSON_QUOTE(?))", [$userType])
                  ->orWhereNull('applicable_roles');
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        // Support both single difficulty and array of difficulties
        if ($difficulty) {
            $query->where('difficulty', $difficulty);
        } elseif ($difficulties && is_array($difficulties)) {
            $query->whereIn('difficulty', $difficulties);
        }

        return $query->inRandomOrder()->limit($count)->get();
    }

    public static function getByCategory($category, $count = null, $userType = null)
    {
        $query = self::where('category', $category)->where('is_active', true);

        // Filter by user_type using applicable_roles JSON
        if ($userType) {
            $query->where(function ($q) use ($userType) {
                $q->whereRaw("JSON_CONTAINS(applicable_roles, JSON_QUOTE(?))", [$userType])
                  ->orWhereNull('applicable_roles');
            });
        }

        if ($count) {
            return $query->inRandomOrder()->limit($count)->get();
        }

        return $query->inRandomOrder()->get();
    }

    public static function countAvailableByDifficulty($userType, $difficulty)
    {
        return self::where('is_active', true)
            ->where('difficulty', $difficulty)
            ->where(function ($q) use ($userType) {
                $q->whereRaw("JSON_CONTAINS(applicable_roles, JSON_QUOTE(?))", [$userType])
                  ->orWhereNull('applicable_roles');
            })
            ->count();
    }

    public static function getDifficultyLevels()
    {
        return ['baja', 'media', 'alta'];
    }

    public static function getDifficultyLabel($difficulty)
    {
        $labels = [
            'baja' => 'Fácil',
            'media' => 'Intermedio',
            'alta' => 'Difícil',
        ];
        return $labels[$difficulty] ?? $difficulty;
    }
}
