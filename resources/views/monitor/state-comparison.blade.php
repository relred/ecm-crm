<x-layouts.app :title="__('Comparación por Estados')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 p-4 md:p-6 lg:p-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <flux:icon.chart-bar class="h-6 w-6"/>
                <h2 class="text-xl font-semibold">Comparación por Estados</h2>
            </div>
            <flux:button href="{{ route('monitor.dashboard') }}" icon="presentation-chart-line" class="bg-gray-800 hover:bg-gray-700">
                Volver al Dashboard
            </flux:button>
        </div>

        <!-- State Comparison Table -->
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Promovidos
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Promotores
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Op. Enlace
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Enlaces Est.
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Operadores
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            % Completado
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($stateStats as $state => $stats)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $state }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($stats['promotedCount']) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($stats['promoterCount']) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($stats['subcoordinatorCount']) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($stats['coordinatorCount']) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($stats['operatorCount']) }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                        <div class="h-2.5 rounded-full {{ $stats['completionPercentage'] >= 70 ? 'bg-green-600' : ($stats['completionPercentage'] >= 40 ? 'bg-yellow-500' : 'bg-red-600') }}"
                                             style="width: {{ $stats['completionPercentage'] }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium {{ $stats['completionPercentage'] >= 70 ? 'text-green-600' : ($stats['completionPercentage'] >= 40 ? 'text-yellow-500' : 'text-red-600') }}">
                                        {{ $stats['completionPercentage'] }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Cards -->

<!--         <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <flux:icon.arrow-trending-up class="w-6 h-6 text-green-600"/>
                    </div>
                    <h3 class="text-lg font-semibold">Estados de Alto Rendimiento</h3>
                </div>
                <div class="text-4xl font-bold text-green-600 mb-2">
                    {{ count(array_filter($stateStats, fn($stats) => $stats['completionPercentage'] >= 70)) }}
                </div>
                <p class="text-gray-600">Estados con más del 70% de avance</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <flux:icon.minus class="w-6 h-6 text-yellow-600"/>
                    </div>
                    <h3 class="text-lg font-semibold">Estados en Progreso</h3>
                </div>
                <div class="text-4xl font-bold text-yellow-500 mb-2">
                    {{ count(array_filter($stateStats, fn($stats) => $stats['completionPercentage'] >= 40 && $stats['completionPercentage'] < 70)) }}
                </div>
                <p class="text-gray-600">Estados entre 40% y 70% de avance</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <flux:icon.arrow-trending-down class="w-6 h-6 text-red-600"/>
                    </div>
                    <h3 class="text-lg font-semibold">Estados en Riesgo</h3>
                </div>
                <div class="text-4xl font-bold text-red-600 mb-2">
                    {{ count(array_filter($stateStats, fn($stats) => $stats['completionPercentage'] < 40)) }}
                </div>
                <p class="text-gray-600">Estados con menos del 40% de avance</p>
            </div>
        </div> -->
    </div>
</x-layouts.app> 