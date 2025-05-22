<x-layouts.app :title="__('Registrar Promovido')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h2>Crear Promovido</h2>
        <div class="w-full max-w-md mx-auto">

            <a href="{{ route('promoted.index') }}" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Volver
            </a>

            <form method="POST" action="{{ route('promoted.store') }}">
                @csrf

                <div>
                    <label for="name" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                    <input type="text" id="name" name="name" placeholder="Nombre" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <div>
                    <label for="phone" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                    <input type="text" id="phone" name="phone" placeholder="Teléfono"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <div>
                    <label for="locality" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Localidad</label>
                    <input type="text" id="locality" name="locality" placeholder="Nombre de la Localidad" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <div>
                    <label for="municipality" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipio (opcional)</label>
                    <input type="text" id="municipality" name="municipality" placeholder="Municipio (opcional)"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <div>
                    <label for="address" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                    <input type="text" id="address" name="address" placeholder="Dirección"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <div>
                    <label for="notes" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas (opcional)</label>
                    <textarea id="notes" name="notes" placeholder="Notas sobre el promovido..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 min-h-[100px]
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                </div>

                <button type="submit"
                    class="mt-5 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2
                    dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Crear
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
