<div>
    <flux:modal id="delete-theme-{{ $theme->id }}" title="{{ __('Supprimer le thème') }}">
        <div class="space-y-4">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Êtes-vous sûr de vouloir supprimer le thème') }} <strong>{{ $theme->title }}</strong> ?
                {{ __('Cette action est irréversible.') }}
            </p>

            <div class="mt-6 flex justify-end space-x-2">
                <flux:button type="button" x-on:click="$dispatch('close-modal', 'delete-theme-{{ $theme->id }}')">
                    {{ __('Annuler') }}
                </flux:button>
                <flux:button type="button" color="danger" wire:click="deleteTheme">
                    {{ __('Supprimer') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
