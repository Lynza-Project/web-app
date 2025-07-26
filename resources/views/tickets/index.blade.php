@php
    use App\Helpers\UserHelper;
@endphp

<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Accueil</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Tickets</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gradient-to-r from-indigo-50 to-slate-50 border border-indigo-100 text-slate-700 px-6 py-4 rounded-xl shadow-sm dark:bg-indigo-900/20 dark:text-indigo-100 dark:border-indigo-800/30">
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xl">🎫</span>
                <h2 class="font-semibold text-lg text-slate-800 dark:text-white">Tickets</h2>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-300 ml-9">
                Retrouvez la liste de tous les tickets de votre organisation. Vous pouvez en ajouter, les modifier ou les supprimer !
            </p>
        </div>

        <div class="w-fit">
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                <x-heroicon-o-plus class="w-4 h-4 mr-2"/>
                Créer un ticket
            </a>
        </div>

        @livewire('tickets')
    </div>
</x-layouts.app>
