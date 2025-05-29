<x-layouts.app :title="__('Promovidos')">
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center">
            <flux:icon.users />
            <h2 class="text-xl ml-2">Promovidos</h2>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('promoted.index') }}" class="flex flex-wrap gap-3 items-center">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Buscar por nombre o localidad"
                class="border rounded-lg px-4 py-2 text-sm dark:bg-gray-800 dark:text-white dark:border-gray-700" />

            <select name="municipality"
                class="border rounded-lg px-4 py-2 text-sm dark:bg-gray-800 dark:text-white dark:border-gray-700">
                <option value="">Todos los municipios</option>
                @foreach ($municipalities as $municipality)
                    <option value="{{ $municipality }}" @selected(request('municipality') == $municipality)>
                        {{ $municipality }}
                    </option>
                @endforeach
            </select>

            <flux:button
                type="submit"
                icon="magnifying-glass"
            >
                Filtrar
            </flux:button>
        </form>

        {{-- Create Button --}}
        <div class="my-4">
            <a href="{{ route('promoted.create') }}"
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                Registrar Promovido
            </a>
        </div>

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
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($promoted as $person)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
