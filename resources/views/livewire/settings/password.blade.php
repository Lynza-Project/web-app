<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Modifiez votre mot de passe')" :subheading="__('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                id="update_password_current_passwordpassword"
                :label="__('Mot de passe actuel')"
                type="password"
                name="current_password"
                required
                autocomplete="current-password"
            />
            <flux:input
                wire:model="password"
                id="update_password_password"
                :label="__('Nouveau mot de passe')"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                id="update_password_password_confirmation"
                :label="__('Confirmez le nouveau mot de passe')"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Enregistrer') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Enregistré.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
