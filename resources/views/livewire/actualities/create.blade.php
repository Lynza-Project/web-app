<div>
    <form wire:submit.prevent="createActuality" class="space-y-6">
        <div>
            <flux:heading size="lg">Créer une actualité</flux:heading>
            <flux:subheading>Renseignez les informations ci-dessous</flux:subheading>
        </div>

        <flux:input label="Titre" placeholder="Titre de l'actualité" wire:model.defer="title"/>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
            <livewire:jodit-text-editor wire:model.live="content" />
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image (optionnelle)</label>
            <input type="file" id="image" wire:model="image"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900">
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if ($image)
                <div class="mt-2">
                    <img alt="Image de l'actualité" src="{{ $image->temporaryUrl() }}" class="h-32 w-auto object-cover rounded-lg">
                </div>
            @endif
        </div>

        <div class="flex">
            <flux:spacer/>
            <flux:button type="submit" variant="primary">
                Créer
            </flux:button>
        </div>
    </form>
</div>
