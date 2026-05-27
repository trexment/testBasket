@extends('layouts.app')

@section('title', 'Pregunta ' . ($index + 1) . ' de ' . $total)

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Progreso -->
    <div class="mb-6">
        <div class="flex justify-between mb-2">
            <span class="font-semibold">Pregunta {{ $index + 1 }} de {{ $total }}</span>
            <span id="timer" class="font-semibold text-blue-600">{{ $timeLimit }}s</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ (($index + 1) / $total) * 100 }}%"></div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-lg shadow">
        <!-- Pregunta -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $question->title }}</h2>
            <p class="text-gray-700 text-lg mb-4">{{ $question->description }}</p>

            @if($question->image_path)
                <img src="{{ asset('storage/' . $question->image_path) }}" alt="Pregunta" class="max-w-full h-auto rounded mb-4">
            @endif

            <p class="text-sm text-gray-500">
                <strong>Categoría:</strong>
                @if($question->category === 'arbitro')
                    👨‍⚖️ Árbitro
                @else
                    📊 Oficial de Mesa
                @endif
                |
                <strong>Dificultad:</strong>
                @if($question->difficulty === 'baja')
                    🟢 Baja
                @elseif($question->difficulty === 'media')
                    🟡 Media
                @else
                    🔴 Alta
                @endif
            </p>
        </div>

        <!-- Opciones de respuesta -->
        <form id="answerForm" action="{{ route('test.answer', ['index' => $index]) }}" method="POST" class="mb-8">
            @csrf
            <input type="hidden" id="timeSpent" name="time_spent" value="0">

            <div class="space-y-4 mb-8">
                @foreach(['A', 'B', 'C', 'D'] as $option)
                    @php
                        $optionText = 'option_' . strtolower($option);
                        $isSelected = $previousAnswer && $previousAnswer->user_answer === $option;
                    @endphp
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition"
                           id="option-{{ $option }}"
                           style="border-color: {{ $isSelected ? '#3b82f6' : '#e5e7eb' }};">
                        <input
                            type="radio"
                            name="answer"
                            value="{{ $option }}"
                            {{ $isSelected ? 'checked' : '' }}
                            class="mr-4 w-5 h-5"
                            onchange="updateOptionStyle()"
                        >
                        <span class="font-semibold text-lg mr-4">{{ $option }}.</span>
                        <span class="text-gray-700">{{ $question->$optionText }}</span>
                    </label>
                @endforeach
            </div>

            <!-- Botones de navegación -->
            <div class="flex gap-4">
                @if($index > 0)
                    <button
                        type="button"
                        onclick="previousQuestion()"
                        class="flex-1 bg-gray-500 text-white font-semibold py-3 rounded hover:bg-gray-600 transition"
                    >
                        ← Anterior
                    </button>
                @endif

                <button
                    type="submit"
                    class="flex-1 bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700 transition"
                >
                    @if($index < $total - 1)
                        Siguiente →
                    @else
                        Finalizar Test ✓
                    @endif
                </button>
            </div>
        </form>

        <!-- Referencia -->
        @if($question->reference)
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-700">
                    <strong>📖 Referencia:</strong> {{ $question->reference }}
                </p>
            </div>
        @endif
    </div>
</div>

<script>
    let startTime = Date.now();
    let timeSpentSeconds = 0;
    const timeLimit = {{ $timeLimit }};
    let timerInterval;

    function startTimer() {
        let secondsLeft = timeLimit;
        const timerElement = document.getElementById('timer');

        timerInterval = setInterval(() => {
            secondsLeft--;
            timerElement.textContent = secondsLeft + 's';

            if (secondsLeft <= 0) {
                clearInterval(timerInterval);
                document.getElementById('answerForm').submit();
            }

            if (secondsLeft <= 10) {
                timerElement.classList.add('text-red-600');
            }
        }, 1000);
    }

    function updateOptionStyle() {
        document.querySelectorAll('label[id^="option-"]').forEach(label => {
            const input = label.querySelector('input[type="radio"]');
            label.style.borderColor = input.checked ? '#3b82f6' : '#e5e7eb';
        });
    }

    function previousQuestion() {
        window.location.href = '{{ route("test.show", ["index" => $index - 1]) }}';
    }

    document.getElementById('answerForm').addEventListener('submit', function() {
        timeSpentSeconds = Math.floor((Date.now() - startTime) / 1000);
        document.getElementById('timeSpent').value = timeSpentSeconds;
        clearInterval(timerInterval);
    });

    // Iniciar cronómetro
    startTimer();
</script>

<style>
    #timer.text-red-600 {
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
@endsection
