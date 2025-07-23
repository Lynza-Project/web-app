<div>
    <form wire:submit.prevent="updateEvent" class="space-y-6">
        <div>
            <flux:heading size="lg">Modifier l'événement</flux:heading>
            <flux:subheading>Modifiez les informations ci-dessous</flux:subheading>
        </div>

        <flux:input label="Titre" placeholder="Titre de l'événement" wire:model.defer="title"/>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <livewire:jodit-text-editor wire:model.live="description" />
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de début <span class="text-red-500">*</span></label>
                <input type="date" id="start_date" wire:model.defer="start_date"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de fin <span class="text-gray-400 text-xs">(optionnel)</span></label>
                <input type="date" id="end_date" wire:model.defer="end_date"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <p class="text-xs text-gray-500 mt-1">Laissez vide si l'événement se déroule sur une seule journée</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Heure de début <span class="text-gray-400 text-xs">(optionnel)</span></label>
                <input type="time" id="start_time" wire:model.defer="start_time"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Heure de fin <span class="text-gray-400 text-xs">(optionnel)</span></label>
                <input type="time" id="end_time" wire:model.defer="end_time"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lieu <span class="text-red-500">*</span></label>
            <input type="text" id="location" wire:model.defer="location"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                placeholder="Lieu de l'événement">
            @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <flux:input type="file" label="Image (optionnelle)" wire:model="newImage" />

        <div class="mt-2">
            @if ($newImage)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Nouvelle image:</p>
                <img src="{{ $newImage->temporaryUrl() }}" class="h-32 w-auto object-cover rounded-lg">
            @elseif ($image)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Image actuelle:</p>
                <img src="{{ asset($image) }}" class="h-32 w-auto object-cover rounded-lg">
            @endif
        </div>

        <div class="flex space-x-3">
            <flux:button type="submit" variant="primary">
                Mettre à jour
            </flux:button>
        </div>
    </form>
</div>
