<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col items-center justify-center space-y-6">
                    <div class="rounded-full bg-green-100 p-3">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl font-semibold text-gray-900">¡Actividad Confirmada!</h2>
                    <p class="text-gray-600 text-center max-w-md">
                        Tu actividad ha sido registrada exitosamente. Gracias por tu participación.
                    </p>
                    
                    <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 