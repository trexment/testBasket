@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-3xl font-bold mb-8">Editar Perfil</h2>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 p-4 rounded mb-6">
            <h3 class="font-bold text-red-800 mb-2">Errores de validación</h3>
            <ul class="text-red-700">
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="block text-gray-700 font-semibold mb-2">
                Nombre Completo
            </label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                required
            >
        </div>

        <div class="mb-6">
            <label for="email" class="block text-gray-700 font-semibold mb-2">
                Email
            </label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ $user->email }}"
                class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-50 text-gray-500 cursor-not-allowed"
                disabled
            >
            <p class="text-sm text-gray-500 mt-2">El email no puede ser modificado</p>
        </div>

        <div class="mb-8">
            <label for="user_type" class="block text-gray-700 font-semibold mb-2">
                Tipo de Usuario
            </label>
            <select
                id="user_type"
                name="user_type"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                required
            >
                <option value="arbitro" {{ $user->user_type === 'arbitro' ? 'selected' : '' }}>
                    👨‍⚖️ Árbitro
                </option>
                <option value="oficial" {{ $user->user_type === 'oficial' ? 'selected' : '' }}>
                    📊 Oficial de Mesa
                </option>
                <option value="entrenador" {{ $user->user_type === 'entrenador' ? 'selected' : '' }}>
                    🏀 Entrenador
                </option>
            </select>
            <p class="text-sm text-gray-600 mt-2">
                Selecciona tu rol para obtener preguntas personalizadas según tu especialidad.
            </p>
        </div>

        <div class="flex gap-4">
            <button
                type="submit"
                class="flex-1 bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700 transition"
            >
                Guardar Cambios
            </button>
            <a
                href="{{ route('profile.show') }}"
                class="flex-1 bg-gray-500 text-white font-semibold py-3 rounded hover:bg-gray-600 transition text-center"
            >
                Cancelar
            </a>
        </div>
    </form>

    <div class="mt-8 bg-blue-50 p-4 rounded border border-blue-200">
        <h3 class="font-bold text-blue-900 mb-2">ℹ️ Información sobre tipos de usuario</h3>
        <ul class="text-sm text-blue-800 space-y-2">
            <li><strong>👨‍⚖️ Árbitro:</strong> Preguntas sobre reglas, faltas, infracciones y decisiones arbitrales</li>
            <li><strong>📊 Oficial de Mesa:</strong> Preguntas sobre anotación, cronometraje, faltas de equipo y estadísticas</li>
            <li><strong>🏀 Entrenador:</strong> Preguntas sobre estrategia, tácticas, gestión de equipo y análisis de juego</li>
        </ul>
    </div>
</div>
@endsection
