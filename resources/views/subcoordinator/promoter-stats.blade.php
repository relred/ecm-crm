<x-layouts.app :title="__('Estadísticas de Promotores')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <flux:icon.users class="h-6 w-6"/>
                <h2 class="text-xl">Estadísticas de Promotores</h2>
            </div>
            <flux:button href="{{ route('subcoordinator.dashboard') }}" icon="arrow-left" class="bg-gray-800 hover:bg-gray-700">
                Volver al Panel
            </flux:button>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <form method="GET" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar Promotor</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Nombre, email o teléfono..."
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm"
                    >
                </div>
                <flux:button type="submit" icon="magnifying-glass">
                    Buscar
                </flux:button>
                @if(request()->hasAny(['search', 'sort', 'direction']))
                    <flux:button href="{{ route('subcoordinator.promoter-stats') }}" color="gray">
                        Limpiar
                    </flux:button>
                @endif
            </form>
        </div>

        <!-- Promoters Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            @php
                                $sortField = request('sort', 'name');
                                $sortDirection = request('direction', 'asc');
                                
                                function sortUrl($field) {
                                    $currentSort = request('sort', 'name');
                                    $currentDirection = request('direction', 'asc');
                                    $newDirection = $field === $currentSort && $currentDirection === 'asc' ? 'desc' : 'asc';
                                    return request()->fullUrlWithQuery([
                                        'sort' => $field,
                                        'direction' => $newDirection
                                    ]);
                                }
                            @endphp
                            
                            <th scope="col" class="px-6 py-3">
                                <a href="{{ sortUrl('name') }}" class="flex items-center gap-1">
                                    Promotor
                                    @if($sortField === 'name')
                                        <svg class="w-3 h-3 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <a href="{{ sortUrl('total_promoted') }}" class="flex items-center gap-1">
                                    Total Promovidos
                                    @if($sortField === 'total_promoted')
                                        <svg class="w-3 h-3 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <a href="{{ sortUrl('touched_promoted') }}" class="flex items-center gap-1">
                                    Con Seguimiento
                                    @if($sortField === 'touched_promoted')
                                        <svg class="w-3 h-3 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <a href="{{ sortUrl('fully_touched_promoted') }}" class="flex items-center gap-1">
                                    Seguimiento Completo
                                    @if($sortField === 'fully_touched_promoted')
                                        <svg class="w-3 h-3 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                % Seguimiento
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Contacto
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promoters as $promoter)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <div class="flex items-center gap-3">
                                        <img 
                                            class="w-10 h-10 rounded-full"
                                            src="{{ $promoter->photo ? asset('storage/' . $promoter->photo) : 'https://placehold.co/400x400' }}"
                                            alt="{{ $promoter->name }}"
                                        >
                                        <a href="{{ route('promoters.view', $promoter->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                            {{ $promoter->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($promoter->total_promoted) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($promoter->touched_promoted) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($promoter->fully_touched_promoted) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mr-2">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $promoter->touch_percentage }}%"></div>
                                        </div>
                                        <span class="text-sm">{{ $promoter->touch_percentage }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        @if($promoter->email)
                                            <a href="mailto:{{ $promoter->email }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                {{ $promoter->email }}
                                            </a>
                                        @endif
                                        @if($promoter->phone)
                                            <a href="tel:{{ $promoter->phone }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                {{ $promoter->phone }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No se encontraron promotores
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($promoters->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $promoters->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app> 