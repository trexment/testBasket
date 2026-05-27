<?php

namespace App\Http\Controllers;

use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $stats = $this->getUserStats($user->id);

        return view('profile.show', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_type' => 'required|in:arbitro,oficial,entrenador',
        ]);

        Auth::user()->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Perfil actualizado correctamente');
    }

    private function getUserStats($userId)
    {
        $attempts = TestAttempt::where('user_id', $userId)
            ->where('status', 'completed')
            ->get();

        if ($attempts->isEmpty()) {
            return [
                'total_tests' => 0,
                'average_score' => 0,
                'best_score' => 0,
                'worst_score' => 0,
                'total_questions' => 0,
                'correct_answers' => 0,
                'accuracy_percentage' => 0,
                'by_difficulty' => [],
            ];
        }

        $totalTests = $attempts->count();
        $averageScore = $attempts->avg('score_percentage');
        $bestScore = $attempts->max('score_percentage');
        $worstScore = $attempts->min('score_percentage');
        $totalQuestions = $attempts->sum('total_questions');
        $correctAnswers = $attempts->sum('correct_answers');
        $accuracyPercentage = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        // Stats by difficulty
        $byDifficulty = [];
        foreach (['baja', 'media', 'alta'] as $difficulty) {
            $diffAttempts = $attempts->filter(function ($attempt) use ($difficulty) {
                return strpos($attempt->difficulty_filter, $difficulty) !== false;
            });

            if ($diffAttempts->count() > 0) {
                $byDifficulty[$difficulty] = [
                    'count' => $diffAttempts->count(),
                    'average_score' => $diffAttempts->avg('score_percentage'),
                ];
            }
        }

        return [
            'total_tests' => $totalTests,
            'average_score' => $averageScore,
            'best_score' => $bestScore,
            'worst_score' => $worstScore,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'accuracy_percentage' => $accuracyPercentage,
            'by_difficulty' => $byDifficulty,
        ];
    }
}
