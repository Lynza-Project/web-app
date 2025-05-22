<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Annuaire des utilisateurs</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-blue-50 border-t border-b border-blue-300 text-blue-600 px-4 py-3 rounded rounded-lg dark:bg-blue-900 dark:text-blue-100 dark:border-blue-700">
            <p class="font-bold">Utilisateurs 🙋</p>
            <p class="text-sm">
                Retrouvez la liste de tous les utilisateurs de votre organisation. Vous pouvez en ajouter, les modifier ou les supprimer !
            </p>
        </div>

        @livewire('users.create')
        @livewire('users.table')
    </div>
</x-layouts.app>
