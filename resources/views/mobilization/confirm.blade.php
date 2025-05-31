<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col items-center justify-center space-y-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Confirmar Actividad</h2>
                    <p class="text-gray-600 text-center max-w-md">
                        Al hacer clic en el botón, confirmarás que estás activo y participando en la movilización.
                    </p>
                    
                    <form method="POST" action="{{ route('mobilization.confirm') }}" class="mt-6">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-8 py-4 bg-blue-600 border border-transparent rounded-md font-semibold text-lg text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            Confirmar mi actividad
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 