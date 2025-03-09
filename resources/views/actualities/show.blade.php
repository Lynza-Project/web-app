@php
    use App\Helpers\UserHelper;
@endphp

<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('actualities.index') }}">Actualités</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $actuality->title }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mt-1">
            <a href="{{ route('actualities.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-zinc-800 text-gray-900 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-700 transition">
                ← Retour aux actualités
            </a>
        </div>

        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-md overflow-hidden p-6 w-full max-w-3xl mx-auto">
            @if(UserHelper::isAdministrator())
                <a href="#"
                   class="text-sm font-medium mb-4 inline-block text-blue-600 dark:text-blue-400 hover:underline">
                    <flux:button variant="primary" class="cursor-pointer">
                        <x-heroicon-o-pencil class="w-4 h-4"/>
                        Modifier
                    </flux:button>
                </a>
            @endif
            <img src="{{ asset($actuality->image ?? 'img\university.jpg') }}" alt="Image Actualité"
                 class="w-full h-64 object-cover rounded-xl">

            <div class="mt-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $actuality->title }}
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Publié le {{ $actuality->created_at->translatedFormat('d F Y') }}
                </p>

                <div class="mt-4 text-gray-700 dark:text-gray-300 leading-relaxed">
                    {!! nl2br(e($actuality->content)) !!}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
