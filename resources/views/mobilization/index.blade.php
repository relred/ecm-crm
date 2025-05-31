<x-layouts.app :title="__('Movilización')">
    <div class="min-h-screen">
        <div class="max-w-4xl mx-auto py-8">
            <!-- Header Section -->
            <div class="text-center mb-2">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Movilización</h2>
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

            @if($promoted->isMobilized())
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                Este promovido ya ha sido movilizado por {{ $promoted->mobilizedBy->name }} el {{ $promoted->mobilized_at->format('d/m/Y H:i') }}.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white/70 backdrop-blur-sm shadow-xl rounded-2xl mb-8 overflow-hidden border border-white/20">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-5">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <h5 class="text-xl font-semibold text-white">Registrar Movilización</h5>
                        </div>
                    </div>
                    <div class="p-8">
                        <form method="POST" action="{{ route('mobilization.update', $promoted) }}" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <div class="text-center">
                                <flux:button type="submit" variant="primary" icon="check">
                                    Reportar como movilizado
                                </flux:button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app> 