@extends('layouts.app')

@section('title', 'Editar Pregunta')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-3xl font-bold mb-8">Editar Pregunta</h2>

    <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="question_code" class="block text-gray-700 font-semibold mb-2">Código de Pregunta (opcional)</label>
            <input
                type="text"
                id="question_code"
                name="question_code"
                value="{{ old('question_code', $question->question_code) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Ej: ARB-F-001, OFI-M-002"
            >
            @error('question_code')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label for="title" class="block text-gray-700 font-semibold mb-2">Título de la Pregunta</label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $question->title) }}"
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
            >{{ old('description', $question->description) }}</textarea>
            @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-700 font-semibold mb-2">Imagen (opcional)</label>
            @if($question->image_path)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $question->image_path) }}" alt="Imagen actual" class="max-h-32 rounded">
                    <p class="text-sm text-gray-600 mt-1">Imagen actual</p>
                </div>
            @endif
            <input
                type="file"
                id="image"
                name="image"
                accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            <p class="text-xs text-gray-600 mt-1">Máximo 2MB. Dejar en blanco para mantener la actual</p>
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
                        value="{{ old('option_' . strtolower($option), $question->{'option_' . strtolower($option)}) }}"
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
                <option value="A" {{ old('correct_answer', $question->correct_answer) === 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('correct_answer', $question->correct_answer) === 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ old('correct_answer', $question->correct_answer) === 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ old('correct_answer', $question->correct_answer) === 'D' ? 'selected' : '' }}>D</option>
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
            >{{ old('explanation', $question->explanation) }}</textarea>
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
                    <option value="arbitro" {{ old('category', $question->category) === 'arbitro' ? 'selected' : '' }}>👨‍⚖️ Árbitro</option>
                    <option value="oficial_mesa" {{ old('category', $question->category) === 'oficial_mesa' ? 'selected' : '' }}>📊 Oficial de Mesa</option>
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
                    <option value="baja" {{ old('difficulty', $question->difficulty) === 'baja' ? 'selected' : '' }}>🟢 Baja</option>
                    <option value="media" {{ old('difficulty', $question->difficulty) === 'media' ? 'selected' : '' }}>🟡 Media</option>
                    <option value="alta" {{ old('difficulty', $question->difficulty) === 'alta' ? 'selected' : '' }}>🔴 Alta</option>
                </select>
                @error('difficulty')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-3">Tipos de Usuarios Aplicables</label>
            <div class="space-y-2 bg-gray-50 p-4 rounded">
                @foreach(['arbitro' => 'Árbitro', 'oficial' => 'Oficial de Mesa', 'entrenador' => 'Entrenador'] as $value => $label)
                    @php
                        $applicableRoles = old('applicable_roles', $question->applicable_roles ?? []);
                        $isChecked = in_array($value, (array)$applicableRoles);
                    @endphp
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            name="applicable_roles[]"
                            value="{{ $value }}"
                            {{ $isChecked ? 'checked' : '' }}
                            class="mr-2"
                        >
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            <p class="text-xs text-gray-600 mt-2">Deja en blanco para que todos los usuarios puedan acceder</p>
            @error('applicable_roles')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-8">
            <label for="reference" class="block text-gray-700 font-semibold mb-2">Referencia</label>
            <input
                type="text"
                id="reference"
                name="reference"
                value="{{ old('reference', $question->reference) }}"
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
                class="flex-1 bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700 transition"
            >
                Guardar Cambios
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
