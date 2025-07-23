<div class="flex space-x-2 mb-4">
    <flux:button wire:click="downloadTemplate" class="w-fit cursor-pointer">
        Fichier d'import
    </flux:button>
    <a href="{{ route('users.import') }}">
        <flux:button class="w-fit cursor-pointer">
            Importer
        </flux:button>
    </a>
</div>
