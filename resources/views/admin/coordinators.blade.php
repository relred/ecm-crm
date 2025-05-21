<x-layouts.app :title="__('Coordinadores')">
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <h2>Coordinadores</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-3">
                            Coordinador
                        </th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">
                            Usuario
                        </th>
                        <th scope="col" class="px-6 py-3 hidden md:table-cell">
                            Celular
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
                                <img class="w-10 h-10 rounded-full" src="https://placehold.co/400x400" alt="Jese image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ $user->name }}</div>
                                    <div class="font-normal text-gray-500">{{ $user->state }}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $user->username }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                {{ $user->phone }}
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
