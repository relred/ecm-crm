<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        @php
            $isActive = \App\Models\MobilizationActivity::where('user_id', auth()->id())->exists();
            $hasEstimate = \App\Models\MobilizationEstimate::where('user_id', auth()->id())->exists();
        @endphp
        
        @if($isActive && !$hasEstimate)
        <div class="bg-amber-50 dark:bg-amber-900/30 border-l-4 border-amber-400 dark:border-amber-500 p-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400 dark:text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-700 dark:text-amber-400">
                            No has establecido tu objetivo de movilización para el día D. Es importante definirlo para poder hacer seguimiento.
                        </p>
                    </div>
                </div>
                <div class="ml-4">
                    <flux:button href="{{ route('mobilization.estimate') }}" color="amber" wire:navigate>
                        Establecer Objetivo
                    </flux:button>
                </div>
            </div>
        </div>
        @endif

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <flux:icon.presentation-chart-line class="h-6 w-6"/>
                <h2 class="text-xl">Panel de Control</h2>
            </div>
            <flux:button href="{{ route('coordinator.subcoordinator-stats') }}" icon="users" class="bg-gray-800 hover:bg-gray-700">
                Ver Estadísticas de Enlaces
            </flux:button>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            <!-- Subcoordinators Card -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-purple-100 text-sm font-medium">Enlaces</p>
                        <p class="text-3xl font-bold">{{ number_format($subcoordinatorCount) }}</p>
                    </div>
                </div>
            </div>

            <!-- Promoters Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100 text-sm font-medium">Promotores</p>
                        <p class="text-3xl font-bold">{{ number_format($promoterCount) }}</p>
                    </div>
                </div>
            </div>

            <!-- Promoted Card -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-emerald-100 text-sm font-medium">Promovidos</p>
                        <p class="text-3xl font-bold">{{ number_format($promotedCount) }}</p>
                    </div>
                </div>
            </div>

            <!-- Touch Progress Card -->
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-amber-100 text-sm font-medium">Seguimientos</p>
                        <p class="text-3xl font-bold">{{ number_format(array_sum($touchCounts)) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Touch Progress -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
                <h3 class="text-lg font-semibold mb-4 dark:text-white">Progreso de Seguimiento</h3>
                <div class="space-y-4">
                    @foreach($touchCounts as $step => $count)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium dark:text-white">Paso {{ $step }}</span>
                                <span class="text-sm font-medium dark:text-white">{{ $count }} ({{ $percentages[$step] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentages[$step] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Subcoordinators -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold dark:text-white">Enlaces Destacados</h3>
                    <flux:button href="{{ route('coordinator.subcoordinator-stats') }}" size="sm" color="gray">
                        Ver Todos
                    </flux:button>
                </div>
                <div class="space-y-4">
                    @foreach($subcoordinators as $sub)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <img 
                                    class="w-10 h-10 rounded-full"
                                    src="{{ $sub->photo ? asset('storage/' . $sub->photo) : 'https://placehold.co/400x400' }}"
                                    alt="{{ $sub->name }}"
                                >
                                <div>
                                    <h4 class="font-medium dark:text-white">{{ $sub->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $sub->municipality }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Promotores</p>
                                    <p class="text-lg font-semibold dark:text-white">{{ number_format($sub->promoter_count) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Promovidos</p>
                                    <p class="text-lg font-semibold dark:text-white">{{ number_format($sub->promoted_count) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Con Seguimiento</p>
                                    <p class="text-lg font-semibold dark:text-white">{{ number_format($sub->touched_count) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Completados</p>
                                    <p class="text-lg font-semibold dark:text-white">{{ number_format($sub->fully_touched_count) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 