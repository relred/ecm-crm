<x-layouts.app :title="$subcoordinator->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img 
                    class="w-16 h-16 rounded-full"
                    src="{{ $subcoordinator->photo ? asset('storage/' . $subcoordinator->photo) : 'https://placehold.co/400x400' }}"
                    alt="{{ $subcoordinator->name }}"
                >
                <div>
                    <h2 class="text-2xl font-semibold dark:text-white">{{ $subcoordinator->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">{{ $subcoordinator->municipality }}</p>
                </div>
            </div>
            <flux:button href="{{ route('coordinator.subcoordinators.index') }}" icon="arrow-left" class="bg-gray-800 hover:bg-gray-700">
                Volver
            </flux:button>
        </div>

        <!-- Contact Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Información de Contacto</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($subcoordinator->email)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                        <a href="mailto:{{ $subcoordinator->email }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $subcoordinator->email }}
                        </a>
                    </div>
                @endif
                @if($subcoordinator->phone)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Teléfono</p>
                        <a href="tel:{{ $subcoordinator->phone }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $subcoordinator->phone }}
                        </a>
                    </div>
                @endif
                @if($subcoordinator->state)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Estado</p>
                        <p class="dark:text-white">{{ $subcoordinator->state }}</p>
                    </div>
                @endif
                @if($subcoordinator->municipality)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Municipio</p>
                        <p class="dark:text-white">{{ $subcoordinator->municipality }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Promoters Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
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
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl">
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
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-xl">
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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

            <!-- Top Promoters -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold dark:text-white">Promotores Destacados</h3>
                </div>
                <div class="space-y-4">
                    @foreach($topPromoters as $promoter)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <img 
                                    class="w-10 h-10 rounded-full"
                                    src="{{ $promoter->photo ? asset('storage/' . $promoter->photo) : 'https://placehold.co/400x400' }}"
                                    alt="{{ $promoter->name }}"
                                >
                                <div>
                                    <h4 class="font-medium dark:text-white">{{ $promoter->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $promoter->municipality }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Promovidos</p>
                                    <p class="text-lg font-semibold dark:text-white">{{ number_format($promoter->total_promoted) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Con Seguimiento</p>
                                    <p class="text-lg font-semibold dark:text-white">{{ number_format($promoter->touched_promoted) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Completados</p>
                                    <p class="text-lg font-semibold dark:text-white">{{ number_format($promoter->fully_touched_promoted) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 