@php
    use App\Helpers\UserHelper;
@endphp

<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('events.index') }}">Événements</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $event->title }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mt-1">
            <a href="{{ route('events.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-zinc-800 text-gray-900 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-700 transition">
                Retour aux événements
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-md overflow-hidden">
                <img src="{{ asset($event->image ?? 'img\university.jpg') }}" alt="Image Événement"
                     class="w-full h-80 object-cover">

                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $event->title }}
                        </h1>

                        @if(UserHelper::isAdministrator())
                            <div class="flex space-x-2">
                                <a href="{{ route('events.edit', $event) }}"
                                   class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <x-heroicon-o-pencil class="w-4 h-4 mr-1"/>
                                    Modifier
                                </a>

                                @if(UserHelper::isAdministrator())
                                    <flux:modal.trigger name="delete-event-{{ $event->id }}">
                                        <button type="button" class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                            <x-heroicon-o-trash class="w-4 h-4 mr-1"/>
                                            Supprimer
                                        </button>
                                    </flux:modal.trigger>

                                    <flux:modal name="delete-event-{{ $event->id }}" class="md:w-[500px] bg-white dark:bg-zinc-900 rounded-lg shadow-xl">
                                        <div class="p-6 space-y-6">
                                            <div class="flex items-center space-x-3 text-red-600 dark:text-red-400">
                                                <x-heroicon-o-exclamation-triangle class="w-10 h-10"/>
                                                <flux:heading size="lg">Supprimer l'événement</flux:heading>
                                            </div>

                                            <p class="text-gray-700 dark:text-gray-300">
                                                Êtes-vous sûr de vouloir supprimer l'événement <span class="font-semibold">{{ $event->title }}</span> ?
                                                <br>
                                                Cette action est irréversible.
                                            </p>

                                            <div class="flex justify-end space-x-3">
                                                <form action="{{ route('events.destroy', $event) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <flux:button type="submit" variant="danger">
                                                        Supprimer
                                                    </flux:button>
                                                </form>
                                            </div>
                                        </div>
                                    </flux:modal>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col space-y-2 mb-4">
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <x-heroicon-o-calendar class="w-5 h-5 mr-1"/>
                            <span>{{ $event->getFormattedDateRange() }}</span>
                        </div>

                        @if($event->hasTimeInfo())
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <x-heroicon-o-clock class="w-5 h-5 mr-1"/>
                            <span>{{ $event->getFormattedTimeRange() }}</span>
                        </div>
                        @endif

                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <x-heroicon-o-map-pin class="w-5 h-5 mr-1"/>
                            <span>{{ $event->location }}</span>
                        </div>
                    </div>

                    <div class="mt-6 text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-md p-6 h-fit">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">À propos</h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Organisateur</h3>
                        <p class="text-gray-900 dark:text-white">{{ $event->user->first_name }} {{ $event->user->last_name }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Organisation</h3>
                        <p class="text-gray-900 dark:text-white">{{ $event->organization->name }}</p>
                    </div>

                    @if($event->created_at !== $event->updated_at)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Dernière modification</h3>
                        <p class="text-gray-900 dark:text-white">Le {{ $event->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
