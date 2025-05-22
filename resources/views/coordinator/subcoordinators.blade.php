<x-layouts.app :title="__('Operadores Enlace')">
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex">
            <flux:icon.lifebuoy/>
            <h2 class="text-xl ml-2">Operadores Enlaces</h2>
        </div>

        <div class="relative overflow-x-auto sm:rounded-lg">
            <div class="my-7">
                <a href="{{ route('coordinator.subcoordinators.create') }}" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Registrar Operador Enlace</a>
            </div>
            <p class="mb-2 text-gray-600">O copie el enlace para compartir un formulario de registro automatico</p>
            <div x-data="{ copied: false }" class="flex items-center gap-2 max-w-md mb-6">
                <input
                    type="text"
                    readonly
                    value="{{ $inviteLink }}"
                    class="border rounded px-3 py-2 w-full text-sm text-zinc-700 dark:text-zinc-300"
                    id="invite-link"
                >
                <button
                    @click="
                        navigator.clipboard.writeText(document.getElementById('invite-link').value);
                        copied = true;
                        setTimeout(() => copied = false, 2000);
                    "
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
                    type="button"
                >
                    Copiar
                </button>
                <span x-show="copied" class="text-green-600 text-sm">¡Copiado!</span>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-3">
                            Enlace
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
