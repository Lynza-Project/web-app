<div>
    <form wire:submit.prevent="updateActuality" class="space-y-6">
        <div>
            <flux:heading size="lg">Modifier l'actualité</flux:heading>
            <flux:subheading>Modifiez les informations ci-dessous</flux:subheading>
        </div>

        <flux:input label="Titre" placeholder="Titre de l'actualité" wire:model.defer="title"/>

        <flux:textarea label="Contenu" placeholder="Contenu de l'actualité" wire:model.defer="content" rows="10" />

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
