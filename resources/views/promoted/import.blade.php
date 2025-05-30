<x-layouts.app :title="__('Importar Promovidos')">

    <div class="flex">
        <flux:icon.table-cells/>
        <h2 class="text-xl ml-2">Promotores</h2>
    </div>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-md space-y-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 border border-green-200 rounded-lg p-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('promoted.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Coordinator -->
            <div>
                <label for="coordinator" class="block text-sm font-medium text-gray-700 mb-1">Coordinador</label>
                <select 
                    name="coordinator_id" 
                    id="coordinator" 
                    required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 text-sm"
                >
                    <option value="">-- Selecciona un Coordinador --</option>
                    @foreach($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}">{{ $coordinator->state }} -- {{ $coordinator->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Subcoordinator -->
            <div>
                <label for="subcoordinator" class="block text-sm font-medium text-gray-700 mb-1">Subcoordinador</label>
                <select 
                    name="subcoordinator_id" 
                    id="subcoordinator" 
                    required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 text-sm"
                >
                    <option value="">-- Selecciona un Subcoordinador --</option>
                </select>
            </div>

            <!-- Promoter -->
            <div>
                <label for="promoter" class="block text-sm font-medium text-gray-700 mb-1">Promotor</label>
                <select 
                    name="promoter_id" 
                    id="promoter" 
                    required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 text-sm"
                >
                    <option value="">-- Selecciona un Promotor --</option>
                </select>
            </div>

            <!-- File Input -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Archivo Excel</label>
                <input 
                    type="file" 
                    name="file" 
                    id="file" 
                    required 
                    class="block w-full text-sm text-gray-500
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-md file:border-0
                           file:text-sm file:font-semibold
                           file:bg-green-50 file:text-green-700
                           hover:file:bg-green-100"
                >
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button 
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors"
                >
                    Importar Promovidos
                </button>
            </div>
        </form>
    </div>
    <div class="text-center mt-6">
        <flux:link href="{{ route('promoted.import.history') }}">Ver historial</flux:link>
    </div>
    
    <script>
        document.getElementById('coordinator').addEventListener('change', function () {
            const coordinatorId = this.value;
            fetch(`/api/subcoordinators/${coordinatorId}`)
                .then(res => res.json())
                .then(data => {
                    const subSelect = document.getElementById('subcoordinator');
                    subSelect.innerHTML = '<option value="">-- Select Subcoordinator --</option>';
                    data.forEach(user => {
                        subSelect.innerHTML += `<option value="${user.id}">${user.name}</option>`;
                    });
                });
        });
    
        document.getElementById('subcoordinator').addEventListener('change', function () {
            const subId = this.value;
            fetch(`/api/promoters/${subId}`)
                .then(res => res.json())
                .then(data => {
                    const promSelect = document.getElementById('promoter');
                    promSelect.innerHTML = '<option value="">-- Select Promoter --</option>';
                    data.forEach(user => {
                        promSelect.innerHTML += `<option value="${user.id}">${user.name}</option>`;
                    });
                });
        });
    </script>
    

</x-layouts.app>
