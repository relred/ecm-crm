<x-layouts.app :title="__('Operadores ECM')">
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex">
            <flux:icon.lifebuoy/>
            <h2 class="text-xl ml-2">Operadores ECM</h2>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="my-7">
                <a href="{{ route('operators.create') }}" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Registrar Operador</a>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-3">
                            Operador
                        </th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">
                            Correo
                        </th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">
                            Celular
                        </th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">
                            Contraseña
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full"
                                    src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://placehold.co/400x400' }}"
                                    alt="{{ $user->name }} image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ $user->name }}</div>
                                    <div class="font-normal text-gray-500">{{ $user->state }}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $user->phone }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $user->public_password }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Ver Usuario</a>
                            </td>
                        </tr>                        
                    @endforeach
                </tbody>
            </table>
            
        </div>

    </div>
</x-layouts.app>
