<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('events.index') }}">Événements</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('events.show', $event) }}">{{ $event->title }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Modifier</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mt-1">
            <a href="{{ route('events.show', $event) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-zinc-800 text-gray-900 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-700 transition">
                Retour à l'événement
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-md overflow-hidden p-6">
            @livewire('events.edit', ['event' => $event])
        </div>
    </div>
</x-layouts.app>
