<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Accueil</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('actualities.index') }}">Actualités</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('actualities.show', $actuality) }}">{{ $actuality->title }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Modifier</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mt-1">
            <a href="{{ route('actualities.show', $actuality) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-zinc-800 text-gray-900 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-700 transition">
                Retour à l'actualité
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-md overflow-hidden p-6">
            @livewire('actualities.edit', ['actuality' => $actuality])
        </div>
    </div>
</x-layouts.app>
