@extends('layouts.app')

@section('title', 'Configurar Test')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-3xl font-bold mb-4 text-center">Configurar Test</h2>

    <div class="mb-6 bg-blue-50 border border-blue-200 rounded p-4">
        <p class="text-blue-800">
            <strong>👤 Usuario:</strong> {{ $user->getUserTypeLabel() }}
        </p>
    </div>

    <form action="{{ route('test.start') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="num_questions" class="block text-gray-700 font-semibold mb-2">
                Cantidad de Preguntas
            </label>
            <div class="flex items-center gap-4">
                <input
                    type="range"
                    id="num_questions"
                    name="num_questions"
                    value="10"
                    min="5"
                    max="50"
                    step="1"
                    class="flex-1"
                    oninput="updateQuestionCount(this.value)"
                >
                <input
                    type="number"
                    id="num_questions_display"
                    value="10"
                    min="5"
                    max="50"
                    class="w-16 px-3 py-2 border border-gray-300 rounded text-center"
                    readonly
                >
            </div>
            <p class="text-sm text-gray-600 mt-2">Rango: 5 - 50 preguntas</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-3">
                Nivel de Dificultad
            </label>
            <div class="space-y-3 bg-gray-50 p-4 rounded">
                @foreach(['baja' => 'Fácil', 'media' => 'Intermedio', 'alta' => 'Difícil'] as $value => $label)
                    @php $count = $availableQuestions[$value] ?? 0; @endphp
                    <label class="flex items-center p-3 rounded border border-gray-200 hover:bg-white cursor-pointer transition">
                        <input
                            type="checkbox"
                            name="difficulty[]"
                            value="{{ $value }}"
                            {{ $count > 0 ? 'checked' : 'disabled' }}
                            class="mr-3 w-4 h-4"
                        >
                        <span class="flex-1">
                            <strong>{{ $label }}</strong>
                            <span class="text-gray-600 text-sm ml-2">({{ $count }} disponibles)</span>
                        </span>
                        @if($count === 0)
                            <span class="text-red-500 text-xs font-semibold">SIN PREGUNTAS</span>
                        @endif
                    </label>
                @endforeach
            </div>
            @if($errors->has('difficulty'))
                <p class="text-red-600 text-sm mt-2">{{ $errors->first('difficulty') }}</p>
            @endif
        </div>

        <div class="mb-8">
            <label for="time_limit" class="block text-gray-700 font-semibold mb-2">
                Tiempo Límite por Pregunta (segundos)
            </label>
            <input
                type="number"
                id="time_limit"
                name="time_limit"
                value="45"
                min="15"
                max="180"
                step="15"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            <p class="text-sm text-gray-600 mt-2">
                Entre 15 y 180 segundos. Los tiempos recomendados son 30, 45 o 60 segundos.
            </p>
        </div>

        <div class="flex gap-4">
            <button
                type="submit"
                class="flex-1 bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700 transition disabled:bg-gray-400"
                id="submitBtn"
            >
                🚀 Comenzar Test
            </button>
            <a
                href="{{ route('dashboard') }}"
                class="flex-1 bg-gray-500 text-white font-semibold py-3 rounded hover:bg-gray-600 transition text-center"
            >
                ❌ Cancelar
            </a>
        </div>
    </form>

    <div class="mt-8 bg-amber-50 border border-amber-200 p-4 rounded">
        <h3 class="font-semibold text-amber-900 mb-2">💡 Consejos para el Test</h3>
        <ul class="text-sm text-amber-800 space-y-1">
            <li>✓ Lee todas las opciones antes de responder</li>
            <li>✓ Los tests más altos tienen preguntas más complejas</li>
            <li>✓ Puedes cambiar tu respuesta antes de pasar a la siguiente</li>
            <li>✓ Tus resultados se guardan automáticamente</li>
        </ul>
    </div>
</div>

<script>
    function updateQuestionCount(value) {
        document.getElementById('num_questions_display').value = value;
    }

    // Validar que al menos una dificultad esté seleccionada
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        const checkboxes = document.querySelectorAll('input[name="difficulty[]"]:checked');
        if (checkboxes.length === 0) {
            e.preventDefault();
            alert('Por favor selecciona al menos un nivel de dificultad');
        }
    });
</script>
@endsection
