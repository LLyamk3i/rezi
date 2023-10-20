<x-filament-panels::page.simple>
    @env('local')
    @php
        $owner = Store::get('view-models.owner');
    @endphp
    {{-- blade-formatter-disable --}}
    <x-dynamic-component
        component="login-link"
        :email="$owner->email"
        :label="$owner->label"
        :guard="$owner->guard"
        :redirect-url="$owner->redirect"
    />
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
