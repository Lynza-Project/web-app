<div>
    <button wire:click="$dispatch('openModal', { id: 'delete-documentation-{{ $documentation->id }}' })" class="text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-300 transition">
        <x-heroicon-o-trash class="w-5 h-5"/>
    </button>

    <flux:modal name="delete-documentation-{{ $documentation->id }}" class="md:w-[500px] bg-white dark:bg-slate-900 rounded-lg shadow-xl">
        <div class="p-6 space-y-6">
            <div class="flex items-center space-x-3 text-rose-600 dark:text-rose-400">
                <x-heroicon-o-exclamation-triangle class="w-10 h-10"/>
                <flux:heading size="lg">Supprimer la documentation</flux:heading>
            </div>

            <p class="text-slate-700 dark:text-slate-300">
                Êtes-vous sûr de vouloir supprimer la documentation <span class="font-semibold">{{ $documentation->title }}</span> ?
                <br>
                Cette action est irréversible.
            </p>

            <div class="flex justify-end space-x-3">
                <flux:button wire:click="deleteDocumentation" variant="danger">
                    Supprimer
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
