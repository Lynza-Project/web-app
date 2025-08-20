@php
    use App\Helpers\UserHelper;
@endphp

<x-layouts.app>
    <main id="main-content" role="main" aria-labelledby="page-title">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            <nav aria-label="Fil d'Ariane" role="navigation">
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" aria-label="Retour à l'accueil">Accueil</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item aria-current="page">Événements</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </nav>

            <header class="bg-gradient-to-r from-indigo-50 to-slate-50 border border-indigo-100 text-slate-700 px-6 py-4 rounded-xl shadow-sm dark:bg-indigo-900/20 dark:text-indigo-100 dark:border-indigo-800/30">
                <div class="flex items-center gap-3 mb-1">
                    <span class="text-xl" aria-hidden="true" role="img" aria-label="Icône calendrier">📅</span>
                    <h1 id="page-title" class="font-semibold text-lg text-slate-800 dark:text-white">Événements</h1>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-300 ml-9">
                    Retrouvez la liste de tous les événements de votre organisation. Vous pouvez en ajouter, les modifier ou les supprimer !
                </p>
            </header>

            @if(UserHelper::isAdministrator())
                <section aria-labelledby="actions-heading">
                    <h2 id="actions-heading" class="sr-only">Actions disponibles</h2>
                    <div class="w-fit">
                        <a href="{{ route('events.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm"
                           aria-label="Créer un nouvel événement">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2" aria-hidden="true"/>
                            Créer un événement
                        </a>
                    </div>
                </section>
            @endif

            <section aria-labelledby="events-list-heading">
                <h2 id="events-list-heading" class="sr-only">Liste des événements</h2>
                @livewire('events')
            </section>
        </div>
    </main>
</x-layouts.app>
