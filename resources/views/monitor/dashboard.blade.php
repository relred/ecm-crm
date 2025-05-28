<x-layouts.app :title="__('Monitoreo')">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <!-- Header Section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative container mx-auto px-6 py-12">
                <div class="text-center">
                    <h2 class="text-xl md:text-5xl font-bold text-white mb-4 tracking-tight">
                        Monitoreo
                    </h2>
                </div>
            </div>
            <!-- Decorative elements -->
            <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full -translate-x-20 -translate-y-20"></div>
            <div class="absolute bottom-0 right-0 w-60 h-60 bg-white/5 rounded-full translate-x-20 translate-y-20"></div>
        </div>
    
        <div class="container mx-auto px-6 -mt-8 relative z-10">
            <!-- Filter Section -->
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 backdrop-blur-sm">
                    <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                            </div>
                            <label for="state" class="text-gray-700 font-semibold text-lg">
                                Filtrar por Estado:
                            </label>
                        </div>
                        
                        <div class="relative">
                            <select name="state" id="state" 
                                    onchange="this.form.submit()"
                                    class="appearance-none bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl px-6 py-3 pr-12 text-gray-700 font-medium focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 hover:border-gray-300 cursor-pointer min-w-[200px]">
                                <option value="">🇲🇽 Nacional</option>
                                @foreach($states as $s)
                                    <option value="{{ $s }}" {{ $state === $s ? 'selected' : '' }}>
                                        📍 {{ $s }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
                <!-- Promovidos Card -->
                <div class="group bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-emerald-100 text-sm font-medium">Promovidos</p>
                            <p class="text-3xl font-bold">{{ number_format($promotedCount) }}</p>
                        </div>
                    </div>
                </div>
    
                <!-- Promotores Card -->
                <div class="group bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-100 text-sm font-medium">Promotores</p>
                            <p class="text-3xl font-bold">{{ number_format($promoterCount) }}</p>
                        </div>
                    </div>
                </div>
    
                <!-- Operadores Enlace Card -->
                <div class="group bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-purple-100 text-sm font-medium">Op. Enlace</p>
                            <p class="text-3xl font-bold">{{ number_format($subcoordinatorCount) }}</p>
                        </div>
                    </div>
                </div>
    
                <!-- Operators Card -->
                <div class="group bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-orange-100 text-sm font-medium">Operators</p>
                            <p class="text-3xl font-bold">{{ number_format($operatorCount) }}</p>
                        </div>
                    </div>
                </div>
    
                <!-- Enlaces Estatales Card -->
                <div class="group bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-indigo-100 text-sm font-medium">Enlaces Est.</p>
                            <p class="text-3xl font-bold">{{ number_format($coordinatorCount) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout: Summary and Toques Registrados -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Summary Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Resumen</h2>
                        <p class="text-gray-600 mb-6">Vista consolidada del sistema</p>
                        
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        
                        <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        </div>
                    </div>
                </div>

                <!-- Toques Registrados Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Toques Registrados</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach ([1, 2, 3] as $step)
                            <div class="group bg-gradient-to-r from-gray-50 to-gray-100 hover:from-indigo-50 hover:to-purple-50 rounded-xl p-4 transition-all duration-300 border border-gray-200 hover:border-indigo-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 min-w-0 flex-1">
                                        <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm flex-shrink-0 relative">
                                            {{ $step }}
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 min-w-0 flex-1">
                                            <span class="text-gray-700 font-medium text-sm sm:text-base truncate">
                                                {{ number_format($touchCounts[$step] ?? 0) }} promovidos
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs sm:text-sm font-semibold bg-gradient-to-r from-indigo-500 to-purple-600 text-white flex-shrink-0 w-fit">
                                                {{ $percentages[$step] ?? 0 }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Additional Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Card 1: Avance Promedio Nacional -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                  <div class="text-4xl font-bold text-gray-800 mb-2">72%</div>
                  <div class="text-gray-600 text-sm mb-4">Avance Promedio Nacional</div>
                  <div class="bg-green-500 text-white py-2 px-4 rounded-full text-sm font-medium">
                    Operación Activa
                  </div>
                </div>
              
                <!-- Card 2: Incidentes Reportados -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                  <div class="text-4xl font-bold text-gray-800 mb-2">128</div>
                  <div class="text-gray-600 text-sm mb-4">Incidentes Reportados</div>
                  <div class="bg-yellow-500 text-white py-2 px-4 rounded-full text-sm font-medium">
                    Zona en Revisión
                  </div>
                </div>
              
                <!-- Card 3: Estados por Debajo del 60% -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                  <div class="text-4xl font-bold text-gray-800 mb-2">14</div>
                  <div class="text-gray-600 text-sm mb-4">Estados por Debajo del 60%</div>
                  <div class="bg-red-500 text-white py-2 px-4 rounded-full text-sm font-medium">
                    Atención Urgente
                  </div>
                </div>
              
                <!-- Card 4: Promotores Activos -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                  <div class="text-4xl font-bold text-gray-800 mb-2">21,367</div>
                  <div class="text-gray-600 text-sm mb-4">Promotores Activos</div>
                  <div class="bg-cyan-500 text-white py-2 px-4 rounded-full text-sm font-medium">
                    Cobertura Estable
                  </div>
                </div>
              
                <!-- Card 5: Participación Esperada -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                  <div class="text-4xl font-bold text-gray-800 mb-2">87%</div>
                  <div class="text-gray-600 text-sm mb-4">Participación Esperada</div>
                  <div class="bg-gray-600 text-white py-2 px-4 rounded-full text-sm font-medium">
                    Proyección Alta
                  </div>
                </div>
              
                <!-- Card 6: Zonas Críticas Activadas -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                  <div class="text-4xl font-bold text-gray-800 mb-2">18</div>
                  <div class="text-gray-600 text-sm mb-4">Zonas Críticas Activadas</div>
                  <div class="bg-red-500 text-white py-2 px-4 rounded-full text-sm font-medium">
                    Intervención Legal
                  </div>
                </div>
            </div>

        </div>
    
        <!-- Footer decoration -->
        <div class="h-32 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 via-purple-400 to-indigo-400"></div>
        </div>
    </div>
</x-layouts.app>
