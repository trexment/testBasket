@extends('layouts.app')

@section('title', 'Gestionar Preguntas')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold">Gestionar Preguntas</h2>
        <a href="{{ route('admin.questions.create') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            + Nueva Pregunta
        </a>
    </div>

    @if($questions->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Pregunta</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Categoría</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Dificultad</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($questions as $question)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">
                                {{ $question->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($question->category === 'arbitro')
                                    👨‍⚖️ Árbitro
                                @else
                                    📊 Mesa
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($question->difficulty === 'baja')
                                    🟢 Baja
                                @elseif($question->difficulty === 'media')
                                    🟡 Media
                                @else
                                    🔴 Alta
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($question->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                        Activa
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                        Inactiva
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a
                                    href="{{ route('admin.questions.edit', $question) }}"
                                    class="text-blue-600 hover:text-blue-800 font-semibold"
                                >
                                    Editar
                                </a>
                                <form
                                    action="{{ route('admin.toggle-active', $question) }}"
                                    method="POST"
                                    style="display:inline;"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="text-yellow-600 hover:text-yellow-800 font-semibold"
                                    >
                                        {{ $question->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <form
                                    action="{{ route('admin.questions.destroy', $question) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('¿Estás seguro?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="text-red-600 hover:text-red-800 font-semibold"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $questions->links() }}
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow text-center">
            <p class="text-gray-600 mb-4">No hay preguntas creadas aún</p>
            <a href="{{ route('admin.questions.create') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                + Nueva Pregunta
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
