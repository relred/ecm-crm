<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h2>Crear Enlace estatal</h2>
        <div class="w-full max-w-md mx-auto">
            <form method="POST" action="{{ route('coordinators.store') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="name" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                    <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" name="name" required />
                </div>
    
                <div>
                    <label for="email" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo Electrónico</label>
                    <input type="text" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Correo Electrónico (opcional)" name="email" />
                </div>

                <div>
                    <label for="phone" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono (opcional)</label>
                    <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Teléfono (opcional)" name="phone" />
                </div>
    
                <label for="state" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccione Estado</label>
                <select id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                  <option selected disabled>Seleccionar estado</option>
                    @foreach([
                    'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche',
                    'Chiapas', 'Chihuahua', 'Ciudad de México', 'Coahuila', 'Colima',
                    'Durango', 'Estado de México', 'Guanajuato', 'Guerrero', 'Hidalgo',
                    'Jalisco', 'Michoacán', 'Morelos', 'Nayarit', 'Nuevo León', 'Oaxaca',
                    'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa',
                    'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz', 'Yucatán',
                    'Zacatecas'
                    ] as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
    
                <div>
                    <label for="municipality" class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipio (opcional)</label>
                    <input type="text" id="municipality" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Municipio (opcional)" name="municipality"/>
                </div>
    
                <label class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file">Subir imagen (Opcional)</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*" id="file" name="photo" type="file">
                
                <button type="submit" class="mt-5 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Crear</button>
            </form>
        </div>
    </div>
</x-layouts.app>
