<div>
    <form wire:submit.prevent="updateEvent" class="space-y-6">
        <div>
            <flux:heading size="lg">Modifier l'événement</flux:heading>
            <flux:subheading>Modifiez les informations ci-dessous</flux:subheading>
        </div>

        <flux:input label="Titre" placeholder="Titre de l'événement" wire:model.defer="title"/>

        <flux:textarea label="Description" placeholder="Description de l'événement" wire:model.defer="description" rows="10" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                <input type="date" id="date" wire:model.defer="date"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lieu</label>
                <input type="text" id="location" wire:model.defer="location"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="Lieu de l'événement">
                @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
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
