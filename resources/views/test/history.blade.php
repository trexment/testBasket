@extends('layouts.app')

@section('title', 'Historial de Tests')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold mb-8">Historial de Tests</h2>

    @if($attempts->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Categoría</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Preguntas</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Correctas</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Porcentaje</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Calificación</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($attempts as $attempt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $attempt->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($attempt->category_type === 'arbitro')
                                    👨‍⚖️ Árbitros
                                @elseif($attempt->category_type === 'oficial_mesa')
                                    📊 Mesa
                                @else
                                    🎯 Mixto
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $attempt->total_questions }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                {{ $attempt->correct_answers }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="w-full bg-gray-200 rounded-full h-2" style="width: 100px;">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $attempt->score_percentage }}%"></div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">{{ number_format($attempt->score_percentage, 1) }}%</p>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold">
                                @php
                                    $grade = match(true) {
                                        $attempt->score_percentage >= 90 => 'A',
                                        $attempt->score_percentage >= 80 => 'B',
                                        $attempt->score_percentage >= 70 => 'C',
                                        $attempt->score_percentage >= 60 => 'D',
                                        default => 'F'
                                    };
                                    $color = match($grade) {
                                        'A' => 'text-green-600',
                                        'B' => 'text-blue-600',
                                        'C' => 'text-yellow-600',
                                        'D' => 'text-orange-600',
                                        default => 'text-red-600'
                                    };
                                @endphp
                                <span class="{{ $color }}">{{ $grade }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $attempts->links() }}
        </div>

        <!-- Estadísticas -->
        @php
            $totalTests = $attempts->total();
            $avgScore = $attempts->avg('score_percentage');
            $bestScore = $attempts->max('score_percentage');
        @endphp
        <div class="mt-8 grid grid-cols-3 gap-4">
            <div class="bg-blue-50 p-6 rounded-lg">
                <p class="text-gray-600 mb-2">Tests Realizados</p>
                <p class="text-4xl font-bold text-blue-600">{{ $totalTests }}</p>
            </div>
            <div class="bg-green-50 p-6 rounded-lg">
                <p class="text-gray-600 mb-2">Promedio</p>
                <p class="text-4xl font-bold text-green-600">{{ number_format($avgScore, 1) }}%</p>
            </div>
            <div class="bg-purple-50 p-6 rounded-lg">
                <p class="text-gray-600 mb-2">Mejor Puntuación</p>
                <p class="text-4xl font-bold text-purple-600">{{ number_format($bestScore, 1) }}%</p>
            </div>
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow text-center">
            <p class="text-gray-600 mb-4">No has realizado ningún test aún</p>
            <a href="{{ route('test.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Comenzar un Test
            </a>
        </div>
    @endif

    <div class="mt-8">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
            ← Volver a Dashboard
        </a>
    </div>
</div>
@endsection
