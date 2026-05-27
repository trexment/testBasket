@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Datos del Usuario -->
    <div class="bg-white p-8 rounded-lg shadow mb-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-3xl font-bold">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Editar Perfil
            </a>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded">
                <p class="text-gray-600 mb-1">Tipo de Usuario</p>
                <p class="text-2xl font-bold text-blue-600">{{ $user->getUserTypeLabel() }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded">
                <p class="text-gray-600 mb-1">Rol</p>
                <p class="text-2xl font-bold text-purple-600">
                    {{ $user->role === 'admin' ? 'Administrador' : 'Usuario' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    @if($stats['total_tests'] > 0)
        <div class="bg-white p-8 rounded-lg shadow">
            <h3 class="text-2xl font-bold mb-6">📊 Estadísticas de Tests</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-green-50 p-6 rounded border-l-4 border-green-500">
                    <p class="text-gray-600 mb-2">Tests Completados</p>
                    <p class="text-4xl font-bold text-green-600">{{ $stats['total_tests'] }}</p>
                </div>

                <div class="bg-blue-50 p-6 rounded border-l-4 border-blue-500">
                    <p class="text-gray-600 mb-2">Puntuación Promedio</p>
                    <p class="text-4xl font-bold text-blue-600">
                        {{ number_format($stats['average_score'], 1) }}%
                    </p>
                </div>

                <div class="bg-purple-50 p-6 rounded border-l-4 border-purple-500">
                    <p class="text-gray-600 mb-2">Precisión General</p>
                    <p class="text-4xl font-bold text-purple-600">
                        {{ number_format($stats['accuracy_percentage'], 1) }}%
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="bg-red-50 p-6 rounded">
                    <p class="text-gray-600 mb-2">Mejor Puntuación</p>
                    <p class="text-3xl font-bold text-red-600">{{ number_format($stats['best_score'], 1) }}%</p>
                </div>

                <div class="bg-orange-50 p-6 rounded">
                    <p class="text-gray-600 mb-2">Peor Puntuación</p>
                    <p class="text-3xl font-bold text-orange-600">{{ number_format($stats['worst_score'], 1) }}%</p>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded mb-8">
                <p class="text-gray-600 mb-2">Preguntas Respondidas</p>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-bold text-gray-800">{{ $stats['correct_answers'] }}/{{ $stats['total_questions'] }}</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div
                            class="bg-green-500 h-2 rounded-full"
                            style="width: {{ $stats['accuracy_percentage'] }}%"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas por Dificultad -->
            @if(count($stats['by_difficulty']) > 0)
                <div>
                    <h4 class="text-xl font-bold mb-4">Rendimiento por Dificultad</h4>
                    <div class="space-y-3">
                        @foreach($stats['by_difficulty'] as $difficulty => $data)
                            @php
                                $labels = [
                                    'baja' => ['label' => 'Fácil', 'color' => 'green'],
                                    'media' => ['label' => 'Intermedio', 'color' => 'yellow'],
                                    'alta' => ['label' => 'Difícil', 'color' => 'red'],
                                ];
                                $config = $labels[$difficulty];
                            @endphp
                            <div class="bg-white border border-gray-200 p-4 rounded">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold">{{ $config['label'] }}</span>
                                    <span class="text-gray-600">{{ $data['count'] }} tests</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div
                                            class="bg-{{ $config['color'] }}-500 h-2 rounded-full"
                                            style="width: {{ $data['average_score'] }}%"
                                        ></div>
                                    </div>
                                    <span class="text-lg font-bold text-gray-800 w-16 text-right">
                                        {{ number_format($data['average_score'], 1) }}%
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow text-center">
            <p class="text-gray-600 mb-4">
                Aún no has completado ningún test. ¡Comienza ahora!
            </p>
            <a href="{{ route('test.create') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                Crear Primer Test
            </a>
        </div>
    @endif
</div>
@endsection
