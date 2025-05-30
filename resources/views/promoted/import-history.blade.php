<x-layouts.app :title="__('Importar Promovidos')">

    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Historial de importaciones</h1>
        <flux:button href="{{ route('promoted.import') }}" icon="arrow-left" class="my-6">Volver</flux:button>
    
        @foreach($imports as $import)
            <div class="bg-white shadow rounded-lg p-4 mb-6 border border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <p class="text-sm text-gray-500">ID: <strong>{{ $import->id ?? 'Desconocido' }}</strong></p>
                        <p class="text-sm text-gray-500">Fecha: <strong>{{ $import->created_at->format('Y-m-d H:i') }} -> {{ $import->created_at->diffForHumans() }}</strong></p>
                        <p class="text-sm text-gray-500">Importado por: <strong>{{ $import->creator->name ?? 'Admin' }}</strong></p>
                        <p class="text-sm text-gray-500">Promotor: <strong>{{ $import->promoter->name ?? 'Desconocido' }}</strong></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Total imported: <strong>{{ $import->promoted_count }}</strong></p>
                    </div>
                </div>
    
                <div class="relative max-h-48 overflow-hidden">
                    <ul class="divide-y divide-gray-200">
                        @foreach($import->promoted as $promoted)
                            <li class="py-2">
                                <strong>{{ $promoted->name }}</strong>
                                <span class="text-sm text-gray-500 ml-2">{{ $promoted->phone }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                </div>
            </div>
        @endforeach
    </div>

</x-layouts.app>