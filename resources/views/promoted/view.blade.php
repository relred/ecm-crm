<x-layouts.app :title="__('Ver Promovido')">
  <div class="max-w-md mx-auto">
      <flux:button href="{{ route('promoted.index') }}" icon="arrow-left" class="my-6">Volver</flux:button>
        <div class="bg-white shadow-md rounded-2xl p-6 space-y-6">
          <!-- Header -->
          <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">{{ $promoted->name }}</h1>
            <p class="text-md text-gray-500 mt-1">
                ID de promovido: <span class="font-medium text-gray-700">{{ $promoted->id }}</span>
                <a href="#" class="text-lg text-blue-500 hover:text-blue-700 transition px-3 py-1 rounded border ml-4">
                  Editar
                </a>
            </p>
          </div>
    
          <!-- Info -->
          <div class="space-y-4">
            <div class="flex items-start gap-3">
              <i class="ti ti-car text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">¿Necesita Transporte?</p>
                <p class="text-lg font-medium text-gray-800">
                  @if ($promoted->needs_transport === 1)
                    ✅ Necesita transporte
                  @elseif ($promoted->needs_transport === 0)
                    ❌ No necesita transporte
                  @else
                    🤔 Aún no sabemos
                  @endif
                </p>
              </div>
            </div>

            <div class="flex items-start gap-3">
              <i class="ti ti-walk text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">Estado de Movilización</p>
                <p class="text-lg font-medium text-gray-800">
                  @if ($promoted->isMobilized())
                    ✅ Movilizado
                  @else
                    ❌ No movilizado
                  @endif
                </p>
              </div>
            </div>
    
            <div class="flex items-start gap-3">
              <i class="ti ti-phone text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">Teléfono</p>
                <p class="text-lg font-medium text-gray-800">{{ $promoted->phone }}</p>
              </div>
            </div>
    
            <div class="flex items-start gap-3">
              <i class="ti ti-map-pin text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">Dirección</p>
                <p class="text-lg font-medium text-gray-800">{{ $promoted->address }}</p>
              </div>
            </div>
    
            <div class="flex items-start gap-3">
              <i class="ti ti-building-community text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">Localidad</p>
                <p class="text-lg font-medium text-gray-800">{{ $promoted->locality }}</p>
              </div>
            </div>
    
            <div class="flex items-start gap-3">
              <i class="ti ti-building-bank text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">Municipio</p>
                <p class="text-lg font-medium text-gray-800">{{ $promoted->municipality }}</p>
              </div>
            </div>

            <div class="flex items-start gap-3">
              <i class="ti ti-checklist text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">Seguimiento</p>
                <p class="text-lg font-medium text-gray-800">
                  @php
                      $step = $promoted->currentTouch() ?? 0;
                  @endphp
              
                  @switch($step)
                      @case(0)
                          🚫 Sin avances
                          @break
                      @case(1)
                          ➡️ Paso 1
                          @break
                      @case(2)
                          ➡️ Paso 2
                          @break
                      @case(3)
                          ✅ Completado
                          @break
                      @default
                          🤖 ¿Más de 3 pasos?
                  @endswitch
                </p>
              </div>
            </div>

            <div class="flex items-start gap-3">
              <i class="ti ti-notes text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">Notas</p>
                <p class="text-lg font-medium text-gray-800">{{ $promoted->notes }}</p>
              </div>
            </div>
          </div>
    
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-6">
            <flux:button
                href="{{ route('followup.index', $promoted->id) }}"
                variant="primary"
                icon="signal"
                class="bg-gray-800 hover:bg-gray-700 text-white w-full"
            >
                Dar seguimiento
            </flux:button>

            <flux:button
                href="{{ route('followup.transport', $promoted->id) }}"
                variant="primary"
                icon="truck"
                class="bg-amber-600 hover:bg-amber-500 text-white w-full"
            >
                Editar Transporte
            </flux:button>

            @unless($promoted->isMobilized())
              <div class="sm:col-span-2 flex justify-center">
                <flux:button
                  href="{{ route('mobilization.index', $promoted) }}"
                  icon="check"
                  class="bg-green-600 hover:bg-green-500 text-white w-full sm:w-auto"
                >
                  Registrar Movilización
                </flux:button>
              </div>
            @endunless
          </div>

        
          
            
            <!-- Footer -->
            <div class="border-t pt-4 text-sm text-gray-700 text-center">
              <p>Creado: {{ $promoted->created_at->diffForHumans(); }}</p>
              <p>Actualizado: {{ $promoted->updated_at->diffForHumans(); }}</p>
            </div>
        </div>
      </div>
</x-layouts.app>