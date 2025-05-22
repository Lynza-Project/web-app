@php
    use App\Helpers\UserHelper;
@endphp

<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Actualités</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-blue-50 border-t border-b border-blue-300 text-blue-600 px-4 py-3 rounded rounded-lg dark:bg-blue-900 dark:text-blue-100 dark:border-blue-700">
            <p class="font-bold">Actualités 📰</p>
            <p class="text-sm">
                Retrouvez la liste de toutes les actualités de votre organisation. Vous pouvez en ajouter, les modifier ou les supprimer !
            </p>
        </div>

        @if(UserHelper::isAdministrator())
            <div class="w-fit">
                @livewire('actualities.create')
            </div>
        @endif

        @livewire('actualities')
    </div>
</x-layouts.app>
