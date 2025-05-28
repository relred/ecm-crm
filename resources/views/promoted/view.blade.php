<x-layouts.app :title="__('Ver Promovido')">
    <flux:button href="{{ route('promoted.index') }}" icon="arrow-left">Volver</flux:button>
    <div class="max-w-md mx-auto mt-4">
        <div class="bg-white shadow-md rounded-2xl p-6 space-y-6">
          <!-- Header -->
          <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">{{ $promoted->name }}</h1>
            <p class="text-md text-gray-500 mt-1">
                ID de usuario: <span class="font-medium text-gray-700">{{ $promoted->id }}</span>
                <a href="#" class="text-lg text-blue-500 hover:text-blue-700 transition px-3 py-1 rounded border mx-1">
                  Editar
                </a>
            </p>
          </div>
    
          <!-- Info -->
          <div class="space-y-4">
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
              <i class="ti ti-notes text-gray-400 mt-1"></i>
              <div>
                <p class="text-sm text-gray-500">Notas</p>
                <p class="text-lg font-medium text-gray-800">{{ $promoted->notes }}</p>
              </div>
            </div>
          </div>
    
          <div class="flex justify-center items-center">

            <flux:button
                href="{{ route('followup.index', $promoted->id) }}"
                variant="primary"
                class="bg-gray-800 text-accent-foreground"
            >
                Dar seguimiento
            </flux:button>

          </div>
          
            
            <!-- Footer -->
            <div class="border-t pt-4 text-sm text-gray-700 text-center">
              <p>Creado: {{ $promoted->created_at->diffForHumans(); }}</p>
              <p>Actualizado: {{ $promoted->updated_at->diffForHumans(); }}</p>
            </div>
        </div>
      </div>
</x-layouts.app>