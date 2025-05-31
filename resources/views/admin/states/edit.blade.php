<x-layouts.app :title="__('Editar meta para ' . $state->name)">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar meta para ') . $state->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ $state->name }}</h3>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('states.update', $state) }}">
                        @csrf
                        @method('PUT')

                        <flux:field>
                            <flux:label>Meta de movilizados promovidos</flux:label>

                            <flux:description>Este número representa la meta de movilizados para este estado.</flux:description>

                            <flux:input 
                                type="number"
                                name="goal"
                                :value="old('goal', $state->goal)"
                                min="0"
                                required
                            />

                            <flux:error name="goal" />
                        </flux:field>

                        <div class="flex justify-end mt-4">
                            <a href="{{ route('states.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-400 focus:outline-none focus:border-gray-500 dark:focus:border-gray-400 focus:ring focus:ring-gray-300 dark:focus:ring-gray-400 disabled:opacity-25 transition mr-2">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:border-blue-900 dark:focus:border-blue-600 focus:ring focus:ring-blue-300 dark:focus:ring-blue-400 disabled:opacity-25 transition">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <flux:button href="{{ route('states.index') }}" icon="arrow-left" class="mt-4 ml-1">
                volver
            </flux:button>
        </div>
    </div>

</x-layouts.app> 