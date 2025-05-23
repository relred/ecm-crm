<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>El Camino de México – CRM</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @vite('resources/css/app.css')
    </head>
    <body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen p-6 lg:p-8">

        <!-- Navbar -->
        <header class="w-full max-w-4xl mx-auto text-sm mb-6">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="px-4 py-2 rounded border text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="px-4 py-2 rounded border text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="px-4 py-2 rounded border text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Main Content -->
        <main class="flex flex-1 items-center justify-center text-center">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-bold mb-4">Bienvenido a El Camino de México</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                    Sistema CRM interno.
                </p>

                @guest
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="px-5 py-2 text-sm rounded bg-gray-800 text-white hover:bg-gray-700 transition">
                            Iniciar sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 text-sm rounded border hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                Registrarse
                            </a>
                        @endif
                    </div>
                @endguest
            </div>
        </main>

        <!-- Optional Footer -->
        <footer class="text-center text-xs text-gray-400 mt-8">
            &copy; {{ date('Y') }} El Camino de México.
        </footer>

    </body>
</html>
