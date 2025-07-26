<div>
    <form wire:submit.prevent="updateDocumentation" class="space-y-6">
        <flux:input label="Titre" placeholder="Titre de la documentation" wire:model.defer="title"/>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contenu</label>
            <livewire:jodit-text-editor wire:model.live="content" />
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="newImage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image de couverture</label>

            @if($image)
                <div class="mb-3">
                    <p class="text-sm text-gray-500 mb-2">Image actuelle :</p>
                    <img src="{{ $documentation->image ? Storage::disk('s3')->url($documentation->image) : asset('img/documentation-default.jpg') }}"
                         alt="Image actuelle" class="h-32 w-auto object-cover rounded-lg">
                </div>
            @endif

            <input type="file" id="newImage" wire:model="newImage"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white">
            <p class="text-xs text-gray-500 mt-1">Laissez vide pour conserver l'image actuelle</p>
            @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if ($newImage)
                <div class="mt-2">
                    <p class="text-sm text-gray-500 mb-2">Nouvelle image :</p>
                    <img alt="Nouvelle image" src="{{ $newImage->temporaryUrl() }}" class="h-32 w-auto object-cover rounded-lg">
                </div>
            @endif
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('documentations.show', $documentation) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Annuler
            </a>
            <flux:button type="submit" variant="primary">
                Enregistrer les modifications
            </flux:button>
        </div>
    </form>
</div>
