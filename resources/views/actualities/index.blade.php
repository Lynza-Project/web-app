@php
    use App\Helpers\UserHelper;
@endphp

<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Actualités</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if(UserHelper::isAdministrator())
            <div class="w-fit">
                <flux:modal.trigger name="create-actuality">
                    <flux:button variant="primary">
                        <x-heroicon-o-plus class="w-4 h-4"/>
                        Ajouter une actualité
                    </flux:button>
                </flux:modal.trigger>
            </div>
        @endif

        @livewire('actualities')
    </div>
</x-layouts.app>
