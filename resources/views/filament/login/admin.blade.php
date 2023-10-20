<x-filament-panels::page.simple>
    @env('local')
    @php
        $model = Store::get('view-models.admin');
    @endphp
    {{-- blade-formatter-disable --}}
        <x-dynamic-component
        component="login-link"
        :email="$model->email"
        :label="$model->label"
        :guard="$model->guard"
        :redirect-url="$model->redirect"
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
