@extends('layouts.app')

@section('title', 'Nueva Pregunta')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-3xl font-bold mb-8">Nueva Pregunta</h2>

    <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="title" class="block text-gray-700 font-semibold mb-2">Título de la Pregunta</label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                required
            >
            @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Descripción/Enunciado</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                required
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-700 font-semibold mb-2">Imagen (opcional)</label>
            <input
                type="file"
                id="image"
                name="image"
                accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            <p class="text-xs text-gray-600 mt-1">Máximo 2MB. Formatos: JPG, PNG, GIF</p>
            @error('image')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            @foreach(['A', 'B', 'C', 'D'] as $option)
                <div>
                    <label for="option_{{ strtolower($option) }}" class="block text-gray-700 font-semibold mb-2">
                        Opción {{ $option }}
                    </label>
                    <input
                        type="text"
                        id="option_{{ strtolower($option) }}"
                        name="option_{{ strtolower($option) }}"
                        value="{{ old('option_' . strtolower($option)) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        required
                    >
                    @error('option_' . strtolower($option))
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach
        </div>

        <div class="mb-6">
            <label for="correct_answer" class="block text-gray-700 font-semibold mb-2">Respuesta Correcta</label>
            <select
                id="correct_answer"
                name="correct_answer"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                required
            >
                <option value="">Selecciona la respuesta correcta</option>
                <option value="A" {{ old('correct_answer') === 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('correct_answer') === 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ old('correct_answer') === 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ old('correct_answer') === 'D' ? 'selected' : '' }}>D</option>
            </select>
            @error('correct_answer')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label for="explanation" class="block text-gray-700 font-semibold mb-2">Explicación</label>
            <textarea
                id="explanation"
                name="explanation"
                rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                required
            >{{ old('explanation') }}</textarea>
            @error('explanation')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label for="category" class="block text-gray-700 font-semibold mb-2">Categoría</label>
                <select
                    id="category"
                    name="category"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                    required
                >
                    <option value="">Selecciona una categoría</option>
                    <option value="arbitro" {{ old('category') === 'arbitro' ? 'selected' : '' }}>👨‍⚖️ Árbitro</option>
                    <option value="oficial_mesa" {{ old('category') === 'oficial_mesa' ? 'selected' : '' }}>📊 Oficial de Mesa</option>
                </select>
                @error('category')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="difficulty" class="block text-gray-700 font-semibold mb-2">Dificultad</label>
                <select
                    id="difficulty"
                    name="difficulty"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                    required
                >
                    <option value="">Selecciona dificultad</option>
                    <option value="baja" {{ old('difficulty') === 'baja' ? 'selected' : '' }}>🟢 Baja</option>
                    <option value="media" {{ old('difficulty') === 'media' ? 'selected' : '' }}>🟡 Media</option>
                    <option value="alta" {{ old('difficulty') === 'alta' ? 'selected' : '' }}>🔴 Alta</option>
                </select>
                @error('difficulty')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-8">
            <label for="reference" class="block text-gray-700 font-semibold mb-2">Referencia (Ej: Art. 29 - Regla de 8 segundos)</label>
            <input
                type="text"
                id="reference"
                name="reference"
                value="{{ old('reference') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Art. XX - Nombre de la regla"
            >
            @error('reference')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-4">
            <button
                type="submit"
                class="flex-1 bg-green-600 text-white font-semibold py-3 rounded hover:bg-green-700 transition"
            >
                Crear Pregunta
            </button>
            <a
                href="{{ route('admin.questions.index') }}"
                class="flex-1 bg-gray-500 text-white font-semibold py-3 rounded hover:bg-gray-600 transition text-center"
            >
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
