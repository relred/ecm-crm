<x-layouts.app :title="__('Actualizar Transporte')">
    <div class="max-w-lg mx-auto">
      <flux:button href="{{ route('promoted.view', $promoted) }}" icon="arrow-left" class="my-6">Volver</flux:button>
  
      <div class="bg-white shadow-md rounded-2xl p-6 space-y-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">¿{{ $promoted->name }} necesita transporte?</h2>
        <p>Estado Actual:</p>
        <p>
            @if ($promoted->needs_transport === 1)
                ✅ Necesita transporte
            @elseif ($promoted->needs_transport === 0)
                ❌ No necesita transporte
            @else
                🤔 Aún no sabemos
            @endif
        </p>
        <p class="text-gray-600 mb-6">Selecciona una de las siguientes opciones para registrar el estado de transporte.</p>
  
        <form method="POST" action="{{ route('followup.transport.update', $promoted) }}" class="space-y-4">
          @csrf
          @method('PATCH')
  
          <button type="submit" name="needs_transport" value="1"
              class="w-full px-4 py-3 rounded-xl text-white bg-green-600 hover:bg-green-700 transition shadow">
              ✅ Sí, necesita transporte
          </button>
  
          <button type="submit" name="needs_transport" value="0"
              class="w-full px-4 py-3 rounded-xl text-white bg-red-600 hover:bg-red-700 transition shadow">
              ❌ No necesita transporte
          </button>
  
          <button type="submit" name="needs_transport" value=""
              class="w-full px-4 py-3 rounded-xl text-gray-700 bg-yellow-200 hover:bg-yellow-300 transition shadow">
              🤔 Aún no lo sabemos
          </button>
        </form>
      </div>
    </div>
</x-layouts.app>
  