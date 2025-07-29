<div>
    <form wire:submit.prevent="createTicket" class="space-y-6">
        <div>
            <flux:heading size="lg">Créer un ticket</flux:heading>
            <flux:subheading>Renseignez les informations ci-dessous</flux:subheading>
        </div>

        <flux:input label="Sujet" placeholder="Sujet du ticket" wire:model.defer="subject"/>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <livewire:jodit-text-editor wire:model.live="description" />
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex">
            <flux:spacer/>
            <flux:button type="submit" variant="primary">
                Créer
            </flux:button>
        </div>
    </form>
</div>
