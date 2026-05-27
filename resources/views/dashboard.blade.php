@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="text-center py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">
        Bienvenido, {{ Auth::user()->name }}
    </h1>

    <div class="grid md:grid-cols-2 gap-8 max-w-2xl mx-auto">
        <div class="bg-blue-50 p-8 rounded-lg">
            <h2 class="text-2xl font-bold text-blue-600 mb-4">📝 Nuevo Test</h2>
            <p class="text-gray-600 mb-6">
                Crea un test personalizado eligiendo cantidad, categoría y dificultad
            </p>
            <a href="{{ route('test.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Comenzar
            </a>
        </div>

        <div class="bg-green-50 p-8 rounded-lg">
            <h2 class="text-2xl font-bold text-green-600 mb-4">📊 Historial</h2>
            <p class="text-gray-600 mb-6">
                Revisa tus resultados anteriores y análisis de rendimiento
            </p>
            <a href="{{ route('test.history') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Ver Historial
            </a>
        </div>
    </div>

    @if(Auth::user()->isAdmin())
        <div class="mt-12 bg-purple-50 p-8 rounded-lg">
            <h2 class="text-2xl font-bold text-purple-600 mb-4">⚙️ Panel Administrativo</h2>
            <p class="text-gray-600 mb-6">
                Gestiona las preguntas y configuración de la aplicación
            </p>
            <a href="{{ route('admin.questions.index') }}" class="inline-block bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">
                Ir al Admin
            </a>
        </div>
    @endif
</div>
@endsection
