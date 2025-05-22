<div>
    <flux:modal.trigger name="create-event">
        <flux:button class="w-fit cursor-pointer">
            <x-heroicon-o-plus class="w-4 h-4"/>
            Créer un événement
        </flux:button>
    </flux:modal.trigger>
    <flux:modal name="create-event" class="md:w-[800px] bg-white dark:bg-zinc-900 rounded-lg shadow-xl" wire:listener="close-modal">
        <form wire:submit.prevent="createEvent">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Créer un événement</flux:heading>
                    <flux:subheading>Renseignez les informations ci-dessous</flux:subheading>
                </div>

                <flux:input label="Titre" placeholder="Titre de l'événement" wire:model.defer="title"/>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" rows="6" wire:model.defer="description"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Description de l'événement"></textarea>
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

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image (optionnelle)</label>
                    <input type="file" id="image" wire:model="image"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    @if ($image)
                        <div class="mt-2">
                            <img alt="Image de l'événement" src="{{ Storage::disk('s3')->url($image->temporaryUrl()) }}" class="h-32 w-auto object-cover rounded-lg">
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
