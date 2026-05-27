@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<div class="text-center py-12">
    <h1 class="text-5xl font-bold text-gray-900 mb-4">
        🏀 Cuestionario Baloncesto FEB
    </h1>
    <p class="text-xl text-gray-600 mb-8">
        Entrena con las preguntas oficiales del reglamento FEB para árbitros y oficiales de mesa
    </p>

    <div class="grid md:grid-cols-2 gap-8 max-w-2xl mx-auto">
        <div class="bg-white p-8 rounded-lg shadow">
            <h2 class="text-2xl font-bold text-blue-600 mb-4">👨‍⚖️ Árbitros</h2>
            <p class="text-gray-600 mb-6">
                Tests sobre faltas, infracciones, interpretaciones y reglas de juego
            </p>
        </div>

        <div class="bg-white p-8 rounded-lg shadow">
            <h2 class="text-2xl font-bold text-blue-600 mb-4">📊 Oficiales de Mesa</h2>
            <p class="text-gray-600 mb-6">
                Preguntas sobre anotación, cronometraje y funciones de mesa
            </p>
        </div>
    </div>

    <div class="mt-12">
        @auth
            <a href="{{ route('test.create') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-blue-700">
                Comenzar Test
            </a>
            <a href="{{ route('test.history') }}" class="ml-4 bg-gray-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-gray-700">
                Ver Historial
            </a>
        @else
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-blue-700">
                Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="ml-4 bg-gray-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-gray-700">
                Registrarse
            </a>
        @endauth
    </div>

    <div class="mt-16 bg-blue-50 p-8 rounded-lg">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Características</h3>
        <ul class="text-left max-w-2xl mx-auto space-y-2 text-gray-700">
            <li>✅ Más de 25 preguntas basadas en reglamento FEB oficial</li>
            <li>✅ Tests personalizables (cantidad, categoría, dificultad)</li>
            <li>✅ Cronómetro por pregunta (configurable)</li>
            <li>✅ Explicaciones detalladas con referencias a artículos</li>
            <li>✅ Historial de resultados</li>
            <li>✅ Interfaz responsive (móvil, tablet, desktop)</li>
        </ul>
    </div>
</div>
@endsection
