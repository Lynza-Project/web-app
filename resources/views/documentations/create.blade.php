<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Accueil</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('documentations.index') }}">Documentations</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Créer une documentation</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mt-1">
            <a href="{{ route('documentations.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition">
                Retour aux documentations
            </a>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 shadow-md overflow-hidden p-6">
            @livewire('documentations.create')
        </div>
    </div>
</x-layouts.app>
