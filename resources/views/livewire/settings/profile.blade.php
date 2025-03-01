<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profil')" :subheading="__('Mettez à jour vos informations personnelles.')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="first_name" :label="__('Prénom')" type="text" name="first_name" required autofocus autocomplete="first_name" />
            <flux:input wire:model="last_name" :label="__('Nom')" type="text" name="last_name" required autofocus autocomplete="last_name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" name="email" required autocomplete="email" />
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Enregistrer') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Enregistré.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
