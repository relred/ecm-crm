<x-layouts.app :title="__('Metas Estatales')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Administrar metas por estado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- National Goal Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Meta Nacional</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de Meta Nacional</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ number_format($states->sum('goal')) }}
                            </div>
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">movilizados promovidos</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Estados con Meta Asignada</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $states->where('goal', '>', 0)->count() }}
                            </div>
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">de {{ $states->count() }} estados</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- States Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Meta actual</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($states as $state)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $state->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ number_format($state->goal) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('states.edit', $state) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:border-blue-900 dark:focus:border-blue-600 focus:ring focus:ring-blue-300 dark:focus:ring-blue-400 disabled:opacity-25 transition">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 