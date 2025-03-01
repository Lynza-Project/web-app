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
