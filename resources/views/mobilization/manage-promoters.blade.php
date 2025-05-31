<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Activity Link Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-4">Link de Actividad</h2>
                    <p class="text-gray-600 mb-4">
                        Comparte este link con tus promotores para que confirmen su actividad:
                    </p>

                    <div x-data="{ copied: false }" class="flex items-center gap-2 max-w-md mb-6">
                        <input
                            type="text"
                            readonly
                            value="{{ route('mobilization.confirm') }}"
                            class="border rounded px-3 py-2 w-full text-sm text-zinc-800 dark:text-zinc-700"
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
                </div>
            </div>

            <!-- Promoters Activity Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Estado de Actividad de Promotores</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Municipio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado de Actividad</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($promoters as $promoter)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $promoter->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $promoter->state }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $promoter->municipality }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($promoter->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Activo
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactivo
                                            </span>
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

    @push('scripts')
    <script>
        function copyLink() {
            const linkInput = document.getElementById('activity-link');
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
    @endpush
</x-layouts.app> 