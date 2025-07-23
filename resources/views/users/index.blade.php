<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Annuaire des utilisateurs</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gradient-to-r from-indigo-50 to-slate-50 border border-indigo-100 text-slate-700 px-6 py-4 rounded-xl shadow-sm dark:bg-indigo-900/20 dark:text-indigo-100 dark:border-indigo-800/30">
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xl">🙋</span>
                <h2 class="font-semibold text-lg text-slate-800 dark:text-white">Utilisateurs</h2>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-300 ml-9">
                Retrouvez la liste de tous les utilisateurs de votre organisation. Vous pouvez en ajouter, les modifier ou les supprimer !
            </p>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800/30">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        <div class="flex justify-between items-center">
            @livewire('users.create')
            @livewire('users.import')
        </div>
        @livewire('users.table')
    </div>
</x-layouts.app>
