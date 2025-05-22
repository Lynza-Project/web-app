<div>
    <flux:modal.trigger name="delete-user-{{ $user->id }}">
        <flux:icon name="trash" class="cursor-pointer text-red-600"/>
    </flux:modal.trigger>
    <flux:modal name="delete-user-{{ $user->id }}" class="md:w-96">
        <form wire:submit.prevent="deleteUser">
            <div class="space-y-6">
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
