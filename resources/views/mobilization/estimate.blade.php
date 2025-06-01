<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(!$initialEstimate)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-6">Objetivo de Movilización</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Por favor, establece tu objetivo de movilización para el día D. Este será tu objetivo total de personas a movilizar al final del día.
                    </p>

                    <form method="POST" action="{{ route('mobilization.estimate.goal.submit') }}" class="space-y-6">
                        @csrf

                        <flux:field>
                            <flux:label>¿Cuántas personas estimas que movilizarás en total?</flux:label>
                            <flux:input 
                                type="number" 
                                name="mobilization_goal" 
                                min="1"
                                required />
                            <flux:error name="mobilization_goal" />
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
                                Establecer Objetivo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold">Objetivo de Movilización</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Tu objetivo establecido: <span class="font-semibold">{{ number_format($initialEstimate->mobilization_goal) }}</span> personas</p>
                        @if($initialEstimate->notes)
                            <p class="text-gray-600 dark:text-gray-400 mt-2">Notas: {{ $initialEstimate->notes }}</p>
                        @endif
                    </div>

                </div>
            </div>

            @if($estimates->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Historial de Estimaciones</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Fecha y Hora
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Estimación
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Notas
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($estimates as $estimate)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                        {{ $estimate->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                        {{ number_format($estimate->estimated_count) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ $estimate->notes }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @endif

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

            @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-400 dark:border-green-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400 dark:text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.app> 