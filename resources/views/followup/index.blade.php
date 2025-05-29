<x-layouts.app :title="__('Seguimiento')">
    <div class="min-h-screen">
        
        <div class="max-w-4xl mx-auto py-8">
            <!-- Header Section -->
            <div class="text-center mb-2">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Seguimiento</h2>
                <p class="text-lg text-gray-600">{{ $promoted->name }}</p>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 mx-auto rounded-full mt-3"></div>
            </div>
            <flux:button
                href="{{ route('promoted.view', $promoted->id) }}"
                class="mb-4"
                icon="arrow-left"
            >
                Volver
            </flux:button>
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 text-green-800 px-6 py-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @elseif(session('error'))
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-400 text-red-800 px-6 py-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Register Touch Card -->
            @if ($nextTouch)
            <div class="bg-white/70 backdrop-blur-sm shadow-xl rounded-2xl mb-8 overflow-hidden border border-white/20">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-5">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <h5 class="text-xl font-semibold text-white">Registrar Toque {{ $nextTouch }}</h5>
                    </div>
                </div>
                <div class="p-8">
                    <form method="POST" action="{{ route('followup.touch.store', $promoted) }}" class="space-y-6">
                        @csrf
        
                        <input type="hidden" name="touch_number" value="{{ $nextTouch }}">
        
                        <div class="space-y-2">
                            <label for="method" class="block text-sm font-semibold text-gray-700">Método de contacto</label>
                            <div class="relative">
                                <select name="method" class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50">
                                    <option value="">Seleccionar método...</option>
                                    <option value="call">📞 Llamada</option>
                                    <option value="whatsapp">💬 WhatsApp</option>
                                    <option value="sms">📱 SMS</option>
                                    <option value="other">📋 Otro</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
        
                        <div class="space-y-2">
                            <label for="notes" class="block text-sm font-semibold text-gray-700">Notas y observaciones (Opcional)</label>
                            <textarea name="notes" rows="4" placeholder="Describe el resultado del contacto, próximos pasos, etc..." class="w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50 resize-none">{{ old('notes') }}</textarea>
                        </div>
        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Registrar Toque {{ $nextTouch }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="mb-6 bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-amber-400 text-amber-800 px-6 py-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">¡Seguimiento completado!</p>
                        <p class="text-sm text-amber-700 mt-1">Ya se han registrado los tres toques requeridos.</p>
                    </div>
                </div>
            </div>
        @endif

            <!-- History Section -->
            <div class="bg-white/70 backdrop-blur-sm shadow-xl rounded-2xl overflow-hidden border border-white/20">
                <div class="bg-gradient-to-r from-slate-600 to-gray-700 px-6 py-5">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h4 class="text-xl font-semibold text-white">Historial de Toques</h4>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($touches->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 text-lg">No hay toques registrados aún</p>
                            <p class="text-gray-400 text-sm mt-1">Los toques aparecerán aquí una vez que sean registrados</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($touches as $touch)
                                <div class="bg-gradient-to-r from-white to-gray-50/50 border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-200">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-3">
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-bold rounded-full">
                                                    {{ $touch->touch_number }}
                                                </span>
                                                <div class="flex items-center space-x-2">
                                                    @if($touch->method == 'call')
                                                        <span class="text-green-600">📞</span>
                                                    @elseif($touch->method == 'whatsapp')
                                                        <span class="text-green-600">💬</span>
                                                    @elseif($touch->method == 'sms')
                                                        <span class="text-blue-600">📱</span>
                                                    @else
                                                        <span class="text-gray-600">📋</span>
                                                    @endif
                                                    <span class="font-semibold text-gray-800">{{ ucfirst($touch->method) ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                            
                                            @if($touch->notes)
                                                <div class="bg-blue-50/50 border border-blue-100 rounded-lg p-3 mb-3">
                                                    <p class="text-gray-700 text-sm leading-relaxed">{{ $touch->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500 pt-3 border-t border-gray-100">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $touch->user->name ?? 'Usuario desconocido' }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $touch->touched_at }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>