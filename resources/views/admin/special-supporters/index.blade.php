<x-layouts.app :title="__('Administrar Especiales')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Administrar Especiales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <!-- Analytics Summary -->
                    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/50 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Objetivo de Movilización</h3>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-300">{{ number_format($totalGoal) }}</p>
                        </div>
                        <div class="p-4 bg-green-50 dark:bg-green-900/50 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">Movilizados Actuales</h3>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-300">{{ number_format($totalMobilized) }}</p>
                        </div>
                    </div>

                    <!-- Create New Link Button -->
                    <div class="mb-6">
                        <form action="{{ route('admin.special-supporters.create-link') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                Crear Nuevo Link de Registro
                            </button>
                        </form>
                    </div>

                    @if (session('link'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 rounded-lg">
                            <p class="text-green-700 dark:text-green-200 mb-2">Nuevo link de registro creado:</p>
                            <div class="flex items-center gap-2">
                                <input type="text" value="{{ session('link') }}" 
                                    class="flex-1 p-2 border rounded bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" 
                                    readonly
                                    id="registration-link"
                                    onclick="this.select();">
                                <button onclick="copyLink()" 
                                    class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                    Copiar
                                </button>
                            </div>
                            <p class="text-sm text-green-600 dark:text-green-200 mt-2">
                                Haz clic en el link para seleccionarlo o usa el botón de copiar
                            </p>
                        </div>
                    @endif

                    <!-- Supporters List -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ubicación</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Objetivo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actual</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($supporters as $supporter)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                            {{ $supporter->name ?: 'No registrado' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                            @if ($supporter->state && $supporter->municipality)
                                                {{ $supporter->state }}, {{ $supporter->municipality }}
                                            @else
                                                No registrado
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                            {{ $supporter->mobilized_goal ?: 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                                            {{ $supporter->current_mobilized }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($supporter->is_registered)
                                                <button onclick="openUpdateModal('{{ $supporter->id }}')" 
                                                    class="bg-green-500 hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-800 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Actualizar Conteo
                                                </button>
                                            @else
                                                <button class="bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 font-bold py-1 px-3 rounded text-sm" disabled>
                                                    Actualizar Conteo
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="updateForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                    Actualizar Conteo de Movilizados
                                </h3>
                                <div class="mt-2">
                                    <input type="number" name="current_mobilized" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-300 dark:focus:border-blue-500 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"
                                        placeholder="Ingresa el conteo actual" required min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 dark:bg-blue-600 text-base font-medium text-white hover:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-blue-600 sm:ml-3 sm:w-auto sm:text-sm">
                            Actualizar
                        </button>
                        <button type="button" onclick="closeUpdateModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-blue-600 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openUpdateModal(supporterId) {
            const modal = document.getElementById('updateModal');
            const form = document.getElementById('updateForm');
            form.action = `/admin/special-supporters/${supporterId}/update-mobilized`;
            modal.classList.remove('hidden');
        }

        function closeUpdateModal() {
            const modal = document.getElementById('updateModal');
            modal.classList.add('hidden');
        }

        function copyLink() {
            const linkInput = document.getElementById('registration-link');
            linkInput.select();
            document.execCommand('copy');
            
            // Optional: Show feedback
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = '¡Copiado!';
            setTimeout(() => {
                button.textContent = originalText;
            }, 2000);
        }
    </script>
</x-layouts.app> 