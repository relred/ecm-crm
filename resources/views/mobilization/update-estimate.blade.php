<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold">Actualizar Estimación de Movilización</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Tu objetivo establecido: <span class="font-semibold">{{ number_format($initialEstimate->mobilization_goal) }}</span> personas</p>
                    </div>

                    <form method="POST" action="{{ route('mobilization.estimate.update.submit') }}" class="space-y-6">
                        @csrf

                        <flux:field>
                            <flux:label>¿Cuántas personas estimas que has movilizado hasta ahora?</flux:label>
                            <flux:input 
                                type="number" 
                                name="estimated_count" 
                                min="1"
                                required />
                            <flux:error name="estimated_count" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Notas adicionales (opcional)</flux:label>
                            <flux:textarea 
                                name="notes" 
                                rows="3"
                                placeholder="Agrega cualquier nota o comentario relevante..." />
                            <flux:error name="notes" />
                        </flux:field>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800">
                                Actualizar Estimación
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-400 dark:border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400 dark:text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 dark:text-red-400">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.app> 