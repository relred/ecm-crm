    {{-- resources/views/auth/external-register.blade.php --}}
@props(['title' => "Registro ECM"])

<x-layouts.auth.simple :title="$title">
    <div class="flex flex-col gap-6 max-w-md mx-auto mt-10">
        <x-auth-header :title="__('Registrarse como ' . ucfirst($displayRole))" :description="__('Invitado por: ' . $parent->name)" />

        <form method="POST" action="{{ route('external.register.submit') }}" class="flex flex-col gap-6">
            @csrf

            <input type="hidden" name="parent_id" value="{{ $parent->id }}">
            <input type="hidden" name="state" value="{{ $parent->state }}">
            <input type="hidden" name="role" value="{{ $role }}">

            <flux:input
                name="name"
                :label="__('Name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <flux:input
                name="email"
                :label="__('Email address')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <flux:input
                name="phone"
                :label="__('Numero de celular')"
                type="tel"
                required
                autocomplete="phone"
                placeholder="Celular"
            />

            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Register') }}
            </flux:button>
        </form>

        <div class="text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Already have an account?') }}
            <flux:link :href="route('login')">{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts.auth.simple>
