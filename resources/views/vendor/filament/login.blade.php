<main>
    @env('local')
    @inject('model', AdminLoginPageViewModel::class)
    <section>
        @foreach ($model->fields as $field)
            {{-- blade-formatter-disable --}}
            <x-dynamic-component
                component="login-link"
                :email="$field['email']"
                :label="$field['label']"
                :guard="$model->guard"
                :redirect-url="$model->redirect"
            />
            {{-- blade-formatter-enable --}}
        @endforeach
    </section>
    @endenv
    <form wire:submit.prevent="authenticate" class="space-y-8">
        {{ $this->form }}

        <x-filament::button type="submit" form="authenticate" class="w-full">
            {{ __('filament::login.buttons.submit.label') }}
        </x-filament::button>
    </form>
</main>
