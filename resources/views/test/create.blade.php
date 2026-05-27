@extends('layouts.app')

@section('title', 'Configurar Test')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-3xl font-bold mb-8 text-center">Configurar Test</h2>

    <form action="{{ route('test.start') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="num_questions" class="block text-gray-700 font-semibold mb-2">
                Cantidad de Preguntas (5-50)
            </label>
            <input
                type="number"
                id="num_questions"
                name="num_questions"
                value="10"
                min="5"
                max="50"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                required
            >
        </div>

        <div class="mb-6">
            <label for="category" class="block text-gray-700 font-semibold mb-2">
                Categoría
            </label>
            <select
                id="category"
                name="category"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                required
            >
                <option value="arbitro">👨‍⚖️ Solo Árbitros</option>
                <option value="oficial_mesa">📊 Solo Oficiales de Mesa</option>
                <option value="mixto" selected>🎯 Mixto (Ambos)</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">
                Dificultad
            </label>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="checkbox" name="difficulty[]" value="baja" checked class="mr-2">
                    <span>Baja</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="difficulty[]" value="media" checked class="mr-2">
                    <span>Media</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="difficulty[]" value="alta" checked class="mr-2">
                    <span>Alta</span>
                </label>
            </div>
        </div>

        <div class="mb-8">
            <label for="time_limit" class="block text-gray-700 font-semibold mb-2">
                Tiempo por Pregunta (segundos)
            </label>
            <input
                type="number"
                id="time_limit"
                name="time_limit"
                value="45"
                min="15"
                max="180"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            <p class="text-sm text-gray-600 mt-2">
                Deja en blanco para sin cronómetro, o establece entre 15 y 180 segundos
            </p>
        </div>

        <div class="flex gap-4">
            <button
                type="submit"
                class="flex-1 bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700 transition"
            >
                Comenzar Test
            </button>
            <a
                href="{{ route('dashboard') }}"
                class="flex-1 bg-gray-500 text-white font-semibold py-3 rounded hover:bg-gray-600 transition text-center"
            >
                Cancelar
            </a>
        </div>
    </form>

    <div class="mt-8 bg-blue-50 p-4 rounded">
        <p class="text-sm text-gray-700">
            <strong>ℹ️ Info:</strong>
            Árbitros: {{ $arbitroCount }} preguntas disponibles<br>
            Oficiales de Mesa: {{ $mesaCount }} preguntas disponibles
        </p>
    </div>
</div>
@endsection
