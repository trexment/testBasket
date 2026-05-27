<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $questions = Question::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_code' => 'nullable|string|max:50|unique:questions',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'required|string',
            'category' => 'required|in:arbitro,oficial_mesa',
            'difficulty' => 'required|in:baja,media,alta',
            'applicable_roles' => 'nullable|array',
            'reference' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        Question::create([
            'question_code' => $validated['question_code'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'option_a' => $validated['option_a'],
            'option_b' => $validated['option_b'],
            'option_c' => $validated['option_c'],
            'option_d' => $validated['option_d'],
            'correct_answer' => $validated['correct_answer'],
            'explanation' => $validated['explanation'],
            'category' => $validated['category'],
            'difficulty' => $validated['difficulty'],
            'applicable_roles' => $validated['applicable_roles'] ?? [],
            'reference' => $validated['reference'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Pregunta creada exitosamente');
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_code' => 'nullable|string|max:50|unique:questions,question_code,' . $question->id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'required|string',
            'category' => 'required|in:arbitro,oficial_mesa',
            'difficulty' => 'required|in:baja,media,alta',
            'applicable_roles' => 'nullable|array',
            'reference' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            if ($question->image_path) {
                \Storage::disk('public')->delete($question->image_path);
            }
            $data['image_path'] = $request->file('image')->store('questions', 'public');
        }

        $data['applicable_roles'] = $validated['applicable_roles'] ?? [];

        $question->update($data);

        return redirect()->route('admin.questions.index')->with('success', 'Pregunta actualizada exitosamente');
    }

    public function destroy(Question $question)
    {
        if ($question->image_path) {
            \Storage::disk('public')->delete($question->image_path);
        }

        $question->delete();

        return redirect()->route('admin.questions.index')->with('success', 'Pregunta eliminada exitosamente');
    }

    public function toggleActive(Question $question)
    {
        $question->update(['is_active' => !$question->is_active]);

        return back()->with('success', 'Estado actualizado');
    }
}
