<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Estadísticas de Actividad</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                            $roleNames = [
                                'admin' => 'Administradores',
                                'coordinator' => 'Coordinadores',
                                'operator' => 'Operadores',
                                'subcoordinator' => 'Subcoordinadores',
                                'promoter' => 'Promotores',
                            ];
                        @endphp

                        @foreach($roleNames as $role => $displayName)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $displayName }}</h3>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-3xl font-bold text-blue-600">{{ $roleCounts[$role] ?? 0 }}</p>
                                        <p class="text-sm text-gray-500">activos</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-3xl font-bold {{ ($percentages[$role] ?? 0) > 50 ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ $percentages[$role] ?? 0 }}%
                                        </p>
                                        <p class="text-sm text-gray-500">del total</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Actividad por Estado</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($stateCounts as $stateData)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $stateData->state }}</h3>
                                <p class="text-3xl font-bold text-blue-600">{{ $stateData->count }}</p>
                                <p class="text-sm text-gray-500">personas activas</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 