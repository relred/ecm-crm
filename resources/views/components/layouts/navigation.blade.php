@if(auth()->user()->isAdmin() || auth()->user()->isCoordinator() || auth()->user()->isOperator())
    <x-nav-link :href="route('mobilization.analytics')" :active="request()->routeIs('mobilization.analytics')">
        <x-slot name="icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </x-slot>
        Actividad
    </x-nav-link>

    @if(auth()->user()->isAdmin())
        <x-nav-link :href="route('admin.dday-monitoring.index')" :active="request()->routeIs('admin.dday-monitoring.index')">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </x-slot>
            Monitoreo Día D
        </x-nav-link>
    @endif
@endif

@if(auth()->user()->isSubcoordinator() || auth()->user()->isOperator())
    <x-nav-link :href="route('mobilization.manage-promoters')" :active="request()->routeIs('mobilization.manage-promoters')">
        <x-slot name="icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </x-slot>
        Promotores Activos
    </x-nav-link>
@endif

@if(auth()->user()->isCoordinator() || auth()->user()->isSubcoordinator())
    @php
        $activity = \App\Models\MobilizationActivity::where('user_id', auth()->id())->first();
    @endphp
    
    @if($activity)
        <x-nav-link :href="route('mobilization.estimate')" :active="request()->routeIs('mobilization.estimate')">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </x-slot>
            Estimación de Movilización
        </x-nav-link>
    @endif
@endif 