<div>
    <flux:modal.trigger name="delete-event-{{ $event->id }}">
        <button type="button" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 cursor-pointer">
            <x-heroicon-o-trash class="w-5 h-5"/>
        </button>
    </flux:modal.trigger>

    <flux:modal name="delete-event-{{ $event->id }}" class="md:w-[500px] bg-white dark:bg-zinc-900 rounded-lg shadow-xl" wire:listener="close-modal">
        <div class="p-6 space-y-6">
            <div class="flex items-center space-x-3 text-red-600 dark:text-red-400">
                <x-heroicon-o-exclamation-triangle class="w-10 h-10"/>
                <flux:heading size="lg">Supprimer l'événement</flux:heading>
            </div>

            <p class="text-gray-700 dark:text-gray-300">
                Êtes-vous sûr de vouloir supprimer l'événement <span class="font-semibold">{{ $event->title }}</span> ?
                <br>
                Cette action est irréversible.
            </p>

            <div class="flex justify-end space-x-3">
                <flux:button type="button" variant="danger" wire:click="deleteEvent" wire:loading.attr="disabled">
                    <span wire:loading.remove>Supprimer</span>
                    <span wire:loading>Suppression...</span>
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
