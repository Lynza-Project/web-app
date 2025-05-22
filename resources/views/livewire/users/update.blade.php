<div>
    <flux:modal.trigger name="update-user-{{ $user->id }}">
        <flux:icon name="pencil" class="cursor-pointer text-blue-600"/>
    </flux:modal.trigger>
    <flux:modal name="update-user-{{ $user->id }}" class="md:w-96">
        <form wire:submit.prevent="submit">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Modifier un utilisateur</flux:heading>
                    <flux:subheading>Renseignez les informations ci-dessous</flux:subheading>
                </div>

                <flux:input label="Prénom" placeholder="Prénom" wire:model="first_name"/>
                <flux:input label="Nom" placeholder="Nom" wire:model="last_name"/>
                <flux:input label="Email" placeholder="Email" wire:model="email"/>
                <flux:select wire:model="role" placeholder="Rôle">
                    <flux:select.option value="user">Utilisateur</flux:select.option>
                    <flux:select.option value="admin">Admin</flux:select.option>
                </flux:select>

                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary">
                        Modifier
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
