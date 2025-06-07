<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promovidos - {{ $promoter->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">Promovidos de {{ $promoter->name }}</h1>
                    <a href="{{ route('public.coordinators.promoters', $promoter->parent) }}" class="text-sm text-gray-600 hover:text-gray-900">
                        ← Volver a promotores
                    </a>
                </div>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="px-4 py-6 sm:px-0">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($promoted as $person)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ $person->mobilized ? 'ring-2 ring-green-500' : '' }}">
                                @if($person->mobilized)
                                    <div class="bg-green-50 px-4 py-2 border-b border-green-100">
                                        <p class="text-sm font-medium text-green-800">Movilizado</p>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-lg font-medium text-gray-600">
                                                    {{ Str::substr($person->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2">
                                                <h3 class="text-lg font-medium text-gray-900 truncate">{{ $person->name }}</h3>
                                                @if($person->mobilized)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Mobilizado
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-500">{{ $person->state }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Municipio:</span>
                                            <span class="text-gray-900">{{ $person->municipality }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Localidad:</span>
                                            <span class="text-gray-900">{{ $person->locality }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Sección:</span>
                                            <span class="text-gray-900">{{ $person->section }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Teléfono:</span>
                                            <span class="text-gray-900">{{ $person->phone }}</span>
                                        </div>
                                        @if($person->email)
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-500">Email:</span>
                                                <span class="text-gray-900">{{ $person->email }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 