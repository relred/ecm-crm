<x-layouts.app :title="$promoter->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img 
                    class="w-16 h-16 rounded-full"
                    src="{{ $promoter->photo ? asset('storage/' . $promoter->photo) : 'https://placehold.co/400x400' }}"
                    alt="{{ $promoter->name }}"
                >
                <div>
                    <h2 class="text-2xl font-semibold dark:text-white">{{ $promoter->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">{{ $promoter->municipality }}</p>
                </div>
            </div>
            <flux:button href="{{ route('promoters') }}" icon="arrow-left" class="bg-gray-800 hover:bg-gray-700">
                Volver
            </flux:button>
        </div>

        <!-- Contact Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Información de Contacto</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($promoter->email)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                        <a href="mailto:{{ $promoter->email }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $promoter->email }}
                        </a>
                    </div>
                @endif
                @if($promoter->phone)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Teléfono</p>
                        <a href="tel:{{ $promoter->phone }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $promoter->phone }}
                        </a>
                    </div>
                @endif
                @if($promoter->state)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Estado</p>
                        <p class="dark:text-white">{{ $promoter->state }}</p>
                    </div>
                @endif
                @if($promoter->municipality)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Municipio</p>
                        <p class="dark:text-white">{{ $promoter->municipality }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

            <!-- Completion Rate Card -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-purple-100 text-sm font-medium">Tasa de Completado</p>
                        <p class="text-3xl font-bold">{{ $promotedCount > 0 ? number_format(($touchCounts[3] / $promotedCount) * 100, 1) : '0' }}%</p>
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

            <!-- Recent Promoted -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold dark:text-white">Promovidos Recientes</h3>
                </div>
                <div class="space-y-4">
                    @foreach($recentPromoted as $promoted)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium dark:text-white">{{ $promoted->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $promoted->contact_touches_count }} seguimientos
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 