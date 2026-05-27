<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\TestAnswer;
use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('test.index');
    }

    public function create()
    {
        $user = Auth::user();

        // Get counts for each difficulty level for the user's type
        $difficulties = Question::getDifficultyLevels();
        $availableQuestions = [];

        foreach ($difficulties as $difficulty) {
            $availableQuestions[$difficulty] = Question::countAvailableByDifficulty($user->user_type, $difficulty);
        }

        return view('test.create', [
            'user' => $user,
            'availableQuestions' => $availableQuestions,
            'difficulties' => $difficulties,
        ]);
    }

    public function start(Request $request)
    {
        $validated = $request->validate([
            'num_questions' => 'required|integer|min:5|max:100',
            'difficulty' => 'nullable|array',
            'time_limit' => 'nullable|integer|min:15|max:180',
        ]);

        $numQuestions = $validated['num_questions'];
        $difficulties = $validated['difficulty'] ?? ['baja', 'media', 'alta'];
        $timeLimit = $validated['time_limit'] ?? 45;

        // Get questions based on authenticated user's type
        $questions = $this->getQuestions($numQuestions, Auth::user()->user_type, $difficulties);

        if ($questions->isEmpty()) {
            return back()->with('error', 'No hay suficientes preguntas con los filtros seleccionados');
        }

        // Crear intento de test
        $attempt = TestAttempt::create([
            'user_id' => Auth::id(),
            'total_questions' => count($questions),
            'correct_answers' => 0,
            'score_percentage' => 0,
            'category_type' => Auth::user()->user_type,
            'difficulty_filter' => implode(',', $difficulties),
            'time_limit_seconds' => $timeLimit,
        ]);

        $request->session()->put('test_attempt_id', $attempt->id);
        $request->session()->put('test_questions', $questions->pluck('id')->toArray());
        $request->session()->put('current_question_index', 0);
        $request->session()->put('test_start_time', now());

        return redirect()->route('test.show', ['index' => 0]);
    }

    public function show($index)
    {
        $attemptId = session('test_attempt_id');
        $questions = collect(session('test_questions'));

        if (!$attemptId || !$questions || $index >= count($questions)) {
            return redirect()->route('test.index')->with('error', 'Test no válido');
        }

        $attempt = TestAttempt::find($attemptId);
        $questionId = $questions[$index];
        $question = Question::find($questionId);

        if (!$question) {
            return redirect()->route('test.index')->with('error', 'Pregunta no encontrada');
        }

        $previousAnswer = TestAnswer::where('test_attempt_id', $attemptId)
            ->where('question_id', $questionId)
            ->first();

        return view('test.show', [
            'question' => $question,
            'index' => $index,
            'total' => count($questions),
            'attempt' => $attempt,
            'previousAnswer' => $previousAnswer,
            'timeLimit' => $attempt->time_limit_seconds,
        ]);
    }

    public function submitAnswer(Request $request, $index)
    {
        $validated = $request->validate([
            'answer' => 'nullable|in:A,B,C,D',
            'time_spent' => 'nullable|integer|min:0',
        ]);

        $attemptId = session('test_attempt_id');
        $questions = session('test_questions');

        if (!$attemptId || $index >= count($questions)) {
            return back()->with('error', 'Error en el test');
        }

        $questionId = $questions[$index];
        $answer = $validated['answer'];
        $timeSpent = $validated['time_spent'] ?? 0;

        $question = Question::find($questionId);

        // Eliminar respuesta anterior si existe
        TestAnswer::where('test_attempt_id', $attemptId)
            ->where('question_id', $questionId)
            ->delete();

        // Registrar nueva respuesta
        $isCorrect = $answer === $question->correct_answer;

        TestAnswer::create([
            'test_attempt_id' => $attemptId,
            'question_id' => $questionId,
            'user_answer' => $answer,
            'is_correct' => $isCorrect,
            'time_spent_seconds' => $timeSpent,
        ]);

        $nextIndex = $index + 1;

        if ($nextIndex >= count($questions)) {
            return redirect()->route('test.finish');
        }

        return redirect()->route('test.show', ['index' => $nextIndex]);
    }

    public function finish()
    {
        $attemptId = session('test_attempt_id');

        if (!$attemptId) {
            return redirect()->route('test.index')->with('error', 'Test no encontrado');
        }

        $attempt = TestAttempt::with('answers.question')->find($attemptId);

        if (!$attempt) {
            return redirect()->route('test.index')->with('error', 'Test no encontrado');
        }

        // Calcular resultados
        $totalQuestions = $attempt->total_questions;
        $correctAnswers = $attempt->answers->where('is_correct', true)->count();
        $percentage = ($correctAnswers / $totalQuestions) * 100;

        $attempt->update([
            'correct_answers' => $correctAnswers,
            'score_percentage' => $percentage,
            'status' => 'completed',
        ]);

        // Obtener respuestas incorrectas
        $incorrectAnswers = $attempt->answers->where('is_correct', false);

        // Limpiar sesión
        session()->forget(['test_attempt_id', 'test_questions', 'current_question_index', 'test_start_time']);

        return view('test.finish', [
            'attempt' => $attempt,
            'correctAnswers' => $correctAnswers,
            'totalQuestions' => $totalQuestions,
            'percentage' => $percentage,
            'incorrectAnswers' => $incorrectAnswers,
        ]);
    }

    public function history()
    {
        $attempts = TestAttempt::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('test.history', compact('attempts'));
    }

    private function getQuestions($count, $userType, $difficulties)
    {
        $query = Question::where('is_active', true)
            ->where(function ($q) use ($userType) {
                $q->whereRaw("JSON_CONTAINS(applicable_roles, JSON_QUOTE(?))", [$userType])
                  ->orWhereNull('applicable_roles');
            })
            ->whereIn('difficulty', $difficulties);

        $availableCount = $query->count();
        if ($availableCount < $count) {
            $count = $availableCount;
        }

        return $query->inRandomOrder()->limit($count)->get();
    }
}
