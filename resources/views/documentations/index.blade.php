@php
    use App\Helpers\UserHelper;
@endphp

<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Documentations</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gradient-to-r from-indigo-50 to-slate-50 border border-indigo-100 text-slate-700 px-6 py-4 rounded-xl shadow-sm dark:bg-indigo-900/20 dark:text-indigo-100 dark:border-indigo-800/30">
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xl">📚</span>
                <h2 class="font-semibold text-lg text-slate-800 dark:text-white">Documentations</h2>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-300 ml-9">
                Retrouvez la liste de toutes les documentations de votre organisation. Vous pouvez en ajouter, les modifier ou les supprimer !
            </p>
        </div>

        @if(UserHelper::isAdministrator())
            <div class="w-fit">
                @livewire('documentations.create')
            </div>
        @endif

        @livewire('documentations')
    </div>
</x-layouts.app>
