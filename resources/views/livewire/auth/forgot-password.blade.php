 <div class="flex flex-col gap-6">
    <x-auth-header title="Mot de passe oublié" description="Entrez votre adresse email pour recevoir un lien de réinitialisation de mot de passe." />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            name="email"
            required
            autofocus
            placeholder="email@example.com"
        />

        <flux:button variant="primary" type="submit" class="w-full">{{ __('Réinitialiser le mot de passe') }}</flux:button>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-400">
        Ou,
        <flux:link :href="route('login')" wire:navigate>connectez-vous</flux:link>
    </div>
</div>
