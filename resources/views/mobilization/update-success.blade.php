<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col items-center justify-center space-y-6">
                    <div class="rounded-full bg-green-100 p-3">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl font-semibold text-gray-900">¡Estimación Actualizada!</h2>
                    <p class="text-gray-600 text-center max-w-md">
                        Tu estimación de movilización ha sido actualizada correctamente.
                    </p>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('mobilization.estimate') }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Ver Historial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 