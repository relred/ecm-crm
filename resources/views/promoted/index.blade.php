<x-layouts.app :title="__('Promovidos')">
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center">
            <flux:icon.users />
            <h2 class="text-xl ml-2">Promovidos</h2>
        </div>

        {{-- Create Button --}}
        <div class="my-4">
            <flux:button
                href="{{ route('promoted.create') }}"
                icon="plus"
                variant="primary"
                >
                Registrar Promovido
            </flux:button>
        </div>
        
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('promoted.index') }}"
            class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap gap-3 items-start lg:items-end">
            
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nombre o localidad"
                class="w-full lg:w-auto border rounded-lg px-4 py-2 text-sm dark:bg-gray-800 dark:text-white dark:border-gray-700"
            />
        
            <select
                name="municipality"
                class="w-full lg:w-auto border rounded-lg px-4 py-2 text-sm dark:bg-gray-800 dark:text-white dark:border-gray-700"
            >
                <option value="">Todos los municipios</option>
                @foreach ($municipalities as $municipality)
                    <option value="{{ $municipality }}" @selected(request('municipality') == $municipality)>
                        {{ $municipality }}
                    </option>
                @endforeach
            </select>
        
            <select
                name="needs_transport"
                class="w-full lg:w-auto border rounded-lg px-4 py-2 text-sm dark:bg-gray-800 dark:text-white dark:border-gray-700"
            >
                <option value="">Todos los transportes</option>
                <option value="1" @selected(request('needs_transport') === '1')>✅ Necesita transporte</option>
                <option value="0" @selected(request('needs_transport') === '0')>❌ No necesita transporte</option>
                <option value="null" @selected(request('needs_transport') === 'null')>🤔 Aún no sabemos</option>
            </select>

            <select name="touches"
                class="border rounded-lg px-4 py-2 text-sm dark:bg-gray-800 dark:text-white dark:border-gray-700">
                <option value="">Todos los pasos</option>
                <option value="0" @selected(request('touches') === '0')>🚫 Sin avances</option>
                <option value="1" @selected(request('touches') === '1')>➡️ Paso 1</option>
                <option value="2" @selected(request('touches') === '2')>➡️ Paso 2</option>
                <option value="3" @selected(request('touches') === '3')>✅ Completo (3 pasos)</option>
            </select>


            <div class="flex gap-2 mt-1 lg:mt-0 items-center">
                <flux:button type="submit" icon="magnifying-glass">
                    Filtrar
                </flux:button>
        
                <flux:link color="blue" href="{{ route('promoted.index') }}">
                    Limpiar filtros
                </flux:link>
            </div>
        </form>

        {{-- Table --}}
        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">Localidad</th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">Teléfono</th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">Dirección</th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">Municipio</th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">Toque</th>
                        <th scope="col" class="px-6 py-3 table-cell">Transporte</th>

                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($promoted as $person)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white table-cell">
                                {{ $person->name }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $person->locality }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $person->phone ?? '—' }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $person->address ?? '—' }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $person->municipality ?? '—' }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                @php
                                    $step = $person->currentTouch() ?? 0;
                                @endphp
                            
                                @switch($step)
                                    @case(0)
                                        🚫 Sin avances
                                        @break
                                    @case(1)
                                        ➡️ Paso 1
                                        @break
                                    @case(2)
                                        ➡️ Paso 2
                                        @break
                                    @case(3)
                                        ✅ Completado
                                        @break
                                    @default
                                        🤖 ¿Más de 3 pasos?
                                @endswitch
                            </td>
                            
                            <td class="px-6 py-4 table-cell text-center">
                                @if ($person->needs_transport === 1)
                                    ✅
                                @elseif ($person->needs_transport === 0)
                                    ❌
                                @else
                                    🤔
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <flux:button
                                    href="{{ route('promoted.view', $person->id) }}"
                                    icon:trailing="arrow-up-right">
                                    Ver
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                No hay promovidos registrados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4 px-4">
                {{ $promoted->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
