<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Día D</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div>
        <img src="{{ asset('images/cover.jpeg') }}" alt="Cover" class="w-full">
    </div>
    <div class="container mx-auto px-4 py-8">        
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Promovidos
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Operadores Activos
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Operadores Espejo Activos
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Movilizados
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Uso del Sistema
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($stateStats as $state => $stats)
                        <tr class="{{ !$stats['has_activity'] ? 'bg-red-50' : 'hover:bg-gray-50' }}">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $state }}
                                    @if(!$stats['has_activity'])
                                        <span class="text-red-600 ml-2">(Sin Actividad)</span>
                                    @endif
                                </div>
                                @if(!empty($stats['active_coordinators']))
                                    <div class="text-xs text-gray-500 mt-1">
                                        Enlaces: {{ implode(', ', $stats['active_coordinators']) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $stats['promoted_count'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="text-sm text-gray-900">{{ $stats['active_subcoordinators'] }}</div>
                                    @if($stats['active_subcoordinators'] > 0)
                                        <a href="{{ route('dday.subcoordinators', $state) }}" 
                                           class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Ver
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $stats['active_operators'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $stats['mobilization_estimate'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $bgColor = 'bg-red-200';
                                    $text = 'Ninguno';
                                    
                                    if ($stats['system_usage'] === 1) {
                                        $bgColor = 'bg-green-200';
                                        $text = 'Sistema';
                                    } elseif ($stats['system_usage'] === 2) {
                                        $bgColor = 'bg-yellow-200';
                                        $text = 'Mixto';
                                    } elseif ($stats['system_usage'] === 3) {
                                        $bgColor = 'bg-yellow-200';
                                        $text = 'Whatsapp';
                                    }
                                @endphp
                                <div class="text-sm {{ $bgColor }} px-2 py-1 rounded-full inline-block">
                                    {{ $text }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 