<div>
    <flux:modal.trigger name="delete-user-{{ $user->id }}">
        <flux:icon name="trash" class="cursor-pointer text-red-600"/>
    </flux:modal.trigger>
    <flux:modal name="delete-user-{{ $user->id }}" class="md:w-96">
        <form wire:submit.prevent="deleteUser">
            <div class="p-6 space-y-6">
                <div class="flex items-center space-x-3 text-red-600 dark:text-red-400">
                    <x-heroicon-o-exclamation-triangle class="w-10 h-10"/>
                    <flux:heading size="lg">Supprimer l'utilisateur</flux:heading>
                </div>

                <div>
                    <flux:heading size="lg">Supprimer un utilisateur</flux:heading>
                    <flux:subheading>Êtes-vous sûr de vouloir supprimer
                        <span class="font-semibold">{{ $user->first_name . ' ' . $user->last_name }}</span> ?
                    </flux:subheading>
                </div>

                <div class="flex">
                    <flux:spacer/>

                    <flux:button type="submit" variant="danger">Supprimer</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
