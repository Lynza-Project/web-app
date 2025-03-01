<flux:modal name="create-user" class="md:w-96">
    <form wire:submit.prevent="createUser">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Créer un utilisateur</flux:heading>
                <flux:subheading>Renseignez les informations ci-dessous</flux:subheading>
            </div>

            <flux:input label="Prénom" placeholder="Prénom" wire:model.defer="first_name"/>
            <flux:input label="Nom" placeholder="Nom" wire:model.defer="last_name"/>
            <flux:input label="Email" placeholder="Email" wire:model.defer="email"/>
            <flux:select wire:model.defer="role" placeholder="Rôle">
                <flux:select.option value="user">Utilisateur</flux:select.option>
                <flux:select.option value="admin">Admin</flux:select.option>
            </flux:select>

            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" variant="primary">
                    Créer
                </flux:button>
            </div>
        </div>
    </form>
</flux:modal>
