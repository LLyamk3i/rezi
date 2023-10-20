<x-filament-panels::page.simple>
    @env('local')
    @php
        $providers = Store::get('view-models.providers');
    @endphp
    {{-- blade-formatter-disable --}}
    @foreach ($providers as $provider)
    <x-dynamic-component
        component="login-link"
        :email="$provider->email"
        :label="$provider->label"
        :guard="$provider->guard"
        :redirect-url="$provider->redirect"
    />
    @endforeach
    {{-- blade-formatter-enable --}}
    @endenv
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
    @endif

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>
</x-filament-panels::page.simple>
