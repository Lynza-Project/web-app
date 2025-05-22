<div>
    <flux:modal.trigger name="create-actuality">
        <flux:button class="w-fit cursor-pointer">
            <x-heroicon-o-plus class="w-4 h-4"/>
            Créer une actualité
        </flux:button>
    </flux:modal.trigger>
    <flux:modal name="create-actuality" class="md:w-[800px] bg-white dark:bg-zinc-900 rounded-lg shadow-xl" wire:listener="close-modal">
        <form wire:submit.prevent="createActuality">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Créer une actualité</flux:heading>
                    <flux:subheading>Renseignez les informations ci-dessous</flux:subheading>
                </div>

                <flux:input label="Titre" placeholder="Titre de l'actualité" wire:model.defer="title"/>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contenu</label>
                    <textarea id="content" rows="6" wire:model.defer="content"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Contenu de l'actualité"></textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image (optionnelle)</label>
                    <input type="file" id="image" wire:model="image"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    @if ($image)
                        <div class="mt-2">
                            <img src="{{ $image->temporaryUrl() }}" class="h-32 w-auto object-cover rounded-lg">
                        </div>
                    @endif
                </div>

                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary">
                        Créer
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
