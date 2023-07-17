<main>
    @env('local')
    @inject('model', AdminLoginPageViewModel::class)
    <section>
        <x-login-link :email="$model->email" :guard="$model->guard" :label="$model->label" :redirect-url="$model->redirect" />
    </section>
    @endenv
    <form wire:submit.prevent="authenticate" class="space-y-8">
        {{ $this->form }}

        <x-filament::button type="submit" form="authenticate" class="w-full">
            {{ __('filament::login.buttons.submit.label') }}
        </x-filament::button>
    </form>
</main>