<x-layouts.app :title="__('Monitoreo Día D')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Monitoreo Día D') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- National Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Resumen Nacional</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- National Goal -->
                        <div class="bg-blue-50 dark:bg-blue-900/50 rounded-lg p-6">
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Meta Nacional</h4>
                            <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-300">
                                {{ number_format($nationalGoal) }}
                            </p>
                            <div class="mt-2">
                                <div class="w-full bg-blue-200 dark:bg-blue-700 rounded-full h-2.5">
                                    <div class="bg-blue-600 dark:bg-blue-400 h-2.5 rounded-full" style="width: {{ min($nationalGoalPercentage, 100) }}%"></div>
                                </div>
                                <p class="mt-1 text-sm text-blue-600 dark:text-blue-300">
                                    {{ number_format($nationalGoalPercentage, 1) }}% alcanzado
                                </p>
                            </div>
                        </div>

                        <!-- Estimated Goal -->
<!--                         <div class="bg-green-50 dark:bg-green-900/50 rounded-lg p-6">
                            <h4 class="text-sm font-medium text-green-800 dark:text-green-200">Meta Estimada Total</h4>
                            <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-300">
                                {{ number_format($totalEstimatedGoal) }}
                            </p>
                            <div class="mt-2">
                                <div class="w-full bg-green-200 dark:bg-green-700 rounded-full h-2.5">
                                    <div class="bg-green-600 dark:bg-green-400 h-2.5 rounded-full" style="width: {{ min($estimatedGoalPercentage, 100) }}%"></div>
                                </div>
                                <p class="mt-1 text-sm text-green-600 dark:text-green-300">
                                    {{ number_format($estimatedGoalPercentage, 1) }}% alcanzado
                                </p>
                            </div>
                        </div> -->

                        <!-- Current Mobilized -->
                        <div class="bg-purple-50 dark:bg-purple-900/50 rounded-lg p-6">
                            <h4 class="text-sm font-medium text-purple-800 dark:text-purple-200">Movilizados Actuales</h4>
                            <p class="mt-2 text-3xl font-bold text-purple-600 dark:text-purple-300">
                                {{ number_format($totalCurrentMobilized) }}
                            </p>
                            <div class="mt-2 space-y-1">
                                <div class="flex justify-between text-sm">
                                    <span class="text-purple-600 dark:text-purple-300">Especiales:</span>
                                    <span class="font-medium text-purple-700 dark:text-purple-200">{{ number_format($specialCurrentMobilized) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-purple-600 dark:text-purple-300">Coordinadores:</span>
                                    <span class="font-medium text-purple-700 dark:text-purple-200">{{ number_format($coordinatorCurrentMobilized) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- State Breakdown -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Desglose por Estado</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Meta Estatal</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Meta Estimada</th> -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Movilizados</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">% Meta Estatal</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">% Meta Estimada</th> -->
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($stateBreakdown as $state)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{ $state['name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ number_format($state['goal']) }}
                                        </td>
<!--                                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ number_format($state['total_estimated_goal']) }}
                                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                                (E: {{ number_format($state['special_goal']) }} | C: {{ number_format($state['coordinator_goal']) }})
                                            </span>
                                        </td> -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ number_format($state['total_current_mobilized']) }}
                                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                                (E: {{ number_format($state['special_mobilized']) }} | C: {{ number_format($state['coordinator_mobilized']) }})
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            @php
                                                $stateGoalPercentage = $state['goal'] > 0 ? ($state['total_current_mobilized'] / $state['goal']) * 100 : 0;
                                            @endphp
                                            <div class="flex items-center">
                                                <span class="mr-2">{{ number_format($stateGoalPercentage, 1) }}%</span>
                                                <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                                    <div class="bg-blue-600 dark:bg-blue-400 h-1.5 rounded-full" style="width: {{ min($stateGoalPercentage, 100) }}%"></div>
                                                </div>
                                            </div>
                                        </td>
<!--                                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            @php
                                                $stateEstimatedPercentage = $state['total_estimated_goal'] > 0 ? ($state['total_current_mobilized'] / $state['total_estimated_goal']) * 100 : 0;
                                            @endphp
                                            <div class="flex items-center">
                                                <span class="mr-2">{{ number_format($stateEstimatedPercentage, 1) }}%</span>
                                                <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                                    <div class="bg-green-600 dark:bg-green-400 h-1.5 rounded-full" style="width: {{ min($stateEstimatedPercentage, 100) }}%"></div>
                                                </div>
                                            </div>
                                        </td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 