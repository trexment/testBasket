@extends('layouts.app')

@section('title', 'Resultados del Test')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Resultado General -->
    <div class="bg-white p-8 rounded-lg shadow mb-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Test Completado ✓</h2>

        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-blue-50 p-6 rounded">
                <p class="text-gray-600 mb-2">Puntuación</p>
                <p class="text-4xl font-bold text-blue-600">{{ number_format($percentage, 1) }}%</p>
            </div>
            <div class="bg-green-50 p-6 rounded">
                <p class="text-gray-600 mb-2">Correctas</p>
                <p class="text-4xl font-bold text-green-600">{{ $correctAnswers }}/{{ $totalQuestions }}</p>
            </div>
            <div class="bg-purple-50 p-6 rounded">
                <p class="text-gray-600 mb-2">Calificación</p>
                <p class="text-4xl font-bold text-purple-600">
                    @if($percentage >= 90)
                        A
                    @elseif($percentage >= 80)
                        B
                    @elseif($percentage >= 70)
                        C
                    @elseif($percentage >= 60)
                        D
                    @else
                        F
                    @endif
                </p>
            </div>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $percentage }}%"></div>
        </div>

        <p class="text-gray-600 mb-6">
            Categoría: <strong>
                @if($attempt->category_type === 'arbitro')
                    👨‍⚖️ Árbitros
                @elseif($attempt->category_type === 'oficial_mesa')
                    📊 Oficiales de Mesa
                @else
                    🎯 Mixto
                @endif
            </strong> |
            Fecha: <strong>{{ $attempt->created_at->format('d/m/Y H:i') }}</strong>
        </p>

        <div class="flex gap-4 justify-center">
            <a href="{{ route('test.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Nuevo Test
            </a>
            <a href="{{ route('dashboard') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
                Volver a Dashboard
            </a>
        </div>
    </div>

    <!-- Respuestas Incorrectas -->
    @if($incorrectAnswers->count() > 0)
        <div class="bg-white p-8 rounded-lg shadow">
            <h3 class="text-2xl font-bold mb-6">
                ❌ Preguntas Incorrectas ({{ $incorrectAnswers->count() }})
            </h3>

            <div class="space-y-6">
                @foreach($incorrectAnswers as $answer)
                    @php
                        $question = $answer->question;
                        $correctOptionKey = 'option_' . strtolower($question->correct_answer);
                        $correctOptionText = $question->$correctOptionKey;
                    @endphp
                    <div class="border-l-4 border-red-500 p-4 bg-red-50 rounded">
                        <h4 class="font-bold text-red-600 mb-2">{{ $question->title }}</h4>
                        <p class="text-gray-700 mb-3">{{ $question->description }}</p>

                        <div class="mb-3">
                            <p class="text-sm text-gray-600">
                                <strong>Tu respuesta:</strong> {{ $answer->user_answer ?? 'No respondida' }}
                            </p>
                        </div>

                        <div class="mb-3 p-3 bg-green-100 border border-green-300 rounded">
                            <p class="text-sm">
                                <strong>✓ Respuesta correcta: {{ $question->correct_answer }}</strong>
                            </p>
                            <p class="text-sm text-gray-700">{{ $correctOptionText }}</p>
                        </div>

                        <div class="mb-2 p-3 bg-blue-100 border border-blue-300 rounded">
                            <p class="text-sm font-semibold text-blue-900 mb-1">📚 Explicación:</p>
                            <p class="text-sm text-gray-800">{{ $answer->question->explanation }}</p>
                        </div>

                        @if($question->reference)
                            <p class="text-xs text-gray-600">
                                <strong>📖 Referencia:</strong> {{ $question->reference }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('test.create') }}" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 text-center">
                    Reintentar Fallos
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
