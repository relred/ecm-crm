<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    @if (auth()->user()->role == "admin")
                        <flux:navlist.item icon="cursor-arrow-ripple" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Enlaces Estatales') }}</flux:navlist.item>
                        <flux:navlist.item icon="table-cells" :href="route('promoted.import')" :current="request()->routeIs('promoted.import')" wire:navigate>{{ __('Importar Promovidos') }}</flux:navlist.item>
                    @endif

                    @if (auth()->user()->role == "coordinator")
                        <flux:navlist.item icon="presentation-chart-line" :href="route('coordinator.dashboard')" :current="request()->routeIs('coordinator.dashboard')" wire:navigate>{{ __('Panel de Control') }}</flux:navlist.item>
                        <flux:navlist.item icon="map" :href="route('coordinator.subcoordinators.index')" :current="request()->routeIs('coordinator.subcoordinators.index')" wire:navigate>{{ __('Operadores Enlace') }}</flux:navlist.item>
                        <flux:navlist.item icon="map" :href="route('mobilization.manage-subcoordinators')" :current="request()->routeIs('mobilization.manage-subcoordinators')" wire:navigate>{{ __('Monitorear Mobilizacion') }}</flux:navlist.item>
                    @endif

                    @if (auth()->user()->role == "admin")
                        <flux:navlist.item icon="lifebuoy" :href="route('operators')" :current="request()->routeIs('operators')" wire:navigate>{{ __('Operadores ECM') }}</flux:navlist.item>
                        <flux:navlist.item icon="user" :href="route('admin.special-supporters.index')" :current="request()->routeIs('admin.special-supporters.index')" wire:navigate>{{ __('Movilizadores Especiales') }}</flux:navlist.item>
                        <flux:navlist.item icon="map" :href="route('states.index')" :current="request()->routeIs('states.index')" wire:navigate>{{ __('Metas Estatales') }}</flux:navlist.item>
                        <flux:navlist.item icon="map" :href="route('admin.dday-monitoring.index')" :current="request()->routeIs('admin.dday-monitoring.index')" wire:navigate>{{ __('Monitoreo Día D') }}</flux:navlist.item>
                    @endif

                    @if (auth()->user()->role == "subcoordinator" || auth()->user()->role == "operator")
                        <flux:navlist.item icon="presentation-chart-line" :href="route('subcoordinator.dashboard')" :current="request()->routeIs('subcoordinator.dashboard')" wire:navigate>{{ __('Panel de Control') }}</flux:navlist.item>
                        <flux:navlist.item icon="user" :href="route('promoters')" :current="request()->routeIs('promoters')" wire:navigate>{{ __('Promotores') }}</flux:navlist.item>
                        <flux:navlist.item icon="map" :href="route('mobilization.manage-promoters')" :current="request()->routeIs('mobilization.manage-promoters')" wire:navigate>{{ __('Monitorear Mobilizacion') }}</flux:navlist.item>

                    @endif

                    @if (auth()->user()->role == "promoter" || auth()->user()->role == "operator")
                        <flux:navlist.item icon="user-group" :href="route('promoted.index')" :current="request()->routeIs('promoted.index')" wire:navigate>{{ __('Promovidos') }}</flux:navlist.item>
                    @endif

                    @if (auth()->user()->role == "monitor" || auth()->user()->role == "admin")
                        <flux:navlist.item icon="presentation-chart-line" :href="route('monitor.dashboard')" :current="request()->routeIs('monitor.dashboard')" wire:navigate>{{ __('Monitoreo') }}</flux:navlist.item>
                        <flux:navlist.item icon="presentation-chart-line" :href="route('mobilization.analytics')" :current="request()->routeIs('mobilization.analytics')" wire:navigate>{{ __('Estadísticas de Movilización') }}</flux:navlist.item>
                    @endif

                    @php
                        $user = auth()->user();
                        $isActive = \App\Models\MobilizationActivity::where('user_id', $user->id)->exists();
                    @endphp
                    @if (($user->role == "coordinator" || $user->role == "subcoordinator" || $user->role == "operator") && $isActive)
                        <flux:navlist.item icon="presentation-chart-line" :href="route('mobilization.estimate')" :current="request()->routeIs('mobilization.estimate')" wire:navigate>{{ __('Estimación de Movilización') }}</flux:navlist.item>
                    @endif

                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
{{--                 <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item> --}}
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
