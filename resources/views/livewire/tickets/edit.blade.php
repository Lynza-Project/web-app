<div>
    <form wire:submit.prevent="updateTicket" class="space-y-6">
        <div>
            <flux:heading size="lg">Modifier le ticket</flux:heading>
            <flux:subheading>Modifiez les informations ci-dessous</flux:subheading>
        </div>

        <flux:input label="Sujet" placeholder="Sujet du ticket" wire:model.defer="subject"/>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <livewire:jodit-text-editor wire:model.live="description" />
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut <span class="text-red-500">*</span></label>
            <select id="status" wire:model.defer="status"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <option value="open">Ouvert</option>
                <option value="closed">Fermé</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex">
            <flux:spacer/>
            <flux:button type="submit" variant="primary">
                Mettre à jour
            </flux:button>
        </div>
    </form>
</div>
