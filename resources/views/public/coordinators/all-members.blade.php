<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miembros del Sistema</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Miembros del Sistema</h1>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="px-4 py-6 sm:px-0">
                    <!-- State Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('public.members.index') }}" class="flex gap-4 items-end">
                            <input type="hidden" name="tab" value="{{ $selectedTab }}">
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Estado</label>
                                <select name="state" id="state" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Todos los estados</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state }}" {{ $selectedState === $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Filtrar
                            </button>
                            @if($selectedState)
                                <a href="{{ route('public.members.index', ['tab' => $selectedTab]) }}" class="text-gray-600 hover:text-gray-900 text-sm">
                                    Limpiar filtro
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('public.members.index', ['tab' => 'coordinators', 'state' => $selectedState]) }}" 
                               class="py-2 px-1 border-b-2 font-medium text-sm {{ $selectedTab === 'coordinators' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Enlaces
                            </a>
                            <a href="{{ route('public.members.index', ['tab' => 'subcoordinators', 'state' => $selectedState]) }}" 
                               class="py-2 px-1 border-b-2 font-medium text-sm {{ $selectedTab === 'subcoordinators' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Operadores
                            </a>
                            <a href="{{ route('public.members.index', ['tab' => 'promoters', 'state' => $selectedState]) }}" 
                               class="py-2 px-1 border-b-2 font-medium text-sm {{ $selectedTab === 'promoters' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Promotores
                            </a>
                            <a href="{{ route('public.members.index', ['tab' => 'promoted', 'state' => $selectedState]) }}" 
                               class="py-2 px-1 border-b-2 font-medium text-sm {{ $selectedTab === 'promoted' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Promovidos
                            </a>
                        </nav>
                    </div>

                    <!-- Content -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            @if($selectedTab === 'coordinators')
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Municipio</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operadores</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($data['coordinators'] ?? [] as $coordinator)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full" src="{{ $coordinator->photo ? asset('storage/' . $coordinator->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($coordinator->name) . '&color=7C3AED&background=EBF4FF' }}" alt="{{ $coordinator->name }}">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">{{ $coordinator->name }}</div>
                                                                @if($coordinator->email)
                                                                    <div class="text-sm text-gray-500">{{ $coordinator->email }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $coordinator->state }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $coordinator->municipality }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $coordinator->subcoordinators_count }}</div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No se encontraron coordinadores</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if(isset($data['coordinators']) && $data['coordinators']->hasPages())
                                    <div class="mt-6">
                                        {{ $data['coordinators']->appends(['tab' => $selectedTab, 'state' => $selectedState])->links() }}
                                    </div>
                                @endif
                            @endif

                            @if($selectedTab === 'subcoordinators')
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enlace</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promotores</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($data['subcoordinators'] ?? [] as $subcoordinator)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full" src="{{ $subcoordinator->photo ? asset('storage/' . $subcoordinator->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($subcoordinator->name) . '&color=7C3AED&background=EBF4FF' }}" alt="{{ $subcoordinator->name }}">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">{{ $subcoordinator->name }}</div>
                                                                @if($subcoordinator->email)
                                                                    <div class="text-sm text-gray-500">{{ $subcoordinator->email }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $subcoordinator->parent->name ?? 'N/A' }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $subcoordinator->state }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $subcoordinator->promoters_count }}</div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No se encontraron subcoordinadores</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if(isset($data['subcoordinators']) && $data['subcoordinators']->hasPages())
                                    <div class="mt-6">
                                        {{ $data['subcoordinators']->appends(['tab' => $selectedTab, 'state' => $selectedState])->links() }}
                                    </div>
                                @endif
                            @endif

                            @if($selectedTab === 'promoters')
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Municipio</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promovidos</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($data['promoters'] ?? [] as $promoter)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full" src="{{ $promoter->photo ? asset('storage/' . $promoter->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($promoter->name) . '&color=7C3AED&background=EBF4FF' }}" alt="{{ $promoter->name }}">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">{{ $promoter->name }}</div>
                                                                @if($promoter->email)
                                                                    <div class="text-sm text-gray-500">{{ $promoter->email }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $promoter->state }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $promoter->municipality }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $promoter->promoted_count }}</div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No se encontraron promotores</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if(isset($data['promoters']) && $data['promoters']->hasPages())
                                    <div class="mt-6">
                                        {{ $data['promoters']->appends(['tab' => $selectedTab, 'state' => $selectedState])->links() }}
                                    </div>
                                @endif
                            @endif

                            @if($selectedTab === 'promoted')
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Municipio</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobilizado</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($data['promoted'] ?? [] as $promoted)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">{{ $promoted->name }}</div>
                                                                @if($promoted->email)
                                                                    <div class="text-sm text-gray-500">{{ $promoted->email }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap max-w-[15px] overflow-hidden text-ellipsis">
                                                        <div class="text-sm text-gray-900">{{ $promoted->phone }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap max-w-[15px] overflow-hidden text-ellipsis">
                                                        <div class="text-sm text-gray-900">{{ $promoted->municipality }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if($promoted->mobilized)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                Sí
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                No
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No se encontraron promovidos</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if(isset($data['promoted']) && $data['promoted']->hasPages())
                                    <div class="mt-6">
                                        {{ $data['promoted']->appends(['tab' => $selectedTab, 'state' => $selectedState])->links() }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 