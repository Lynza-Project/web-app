<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Annuaire des utilisateurs</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="w-fit">
            <flux:modal.trigger name="create-user">
                <flux:button  variant="primary">
                    <x-heroicon-o-plus class="w-4 h-4" />
                    Créer un utilisateur
                </flux:button>
            </flux:modal.trigger>
        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @livewire('users')
        </div>
    </div>
    @livewire('users.create-user')

</x-layouts.app>
