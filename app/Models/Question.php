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
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function attempts()
    {
        return $this->hasMany(TestAnswer::class);
    }

    public static function getRandomQuestions($count, $category = null, $difficulty = null)
    {
        $query = self::where('is_active', true);

        if ($category) {
            $query->where('category', $category);
        }

        if ($difficulty) {
            $query->where('difficulty', $difficulty);
        }

        return $query->inRandomOrder()->limit($count)->get();
    }

    public static function getByCategory($category, $count = null)
    {
        $query = self::where('category', $category)->where('is_active', true);

        if ($count) {
            return $query->inRandomOrder()->limit($count)->get();
        }

        return $query->inRandomOrder()->get();
    }
}
