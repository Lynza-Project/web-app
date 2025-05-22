<div>
    @livewire('search-bar', ['model' => 'search', 'width' => 'w-1/3'], key('search-bar'))

    <div wire:loading.remove wire:key="events-index">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div
                    class="flex flex-col bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-md overflow-hidden"
                    wire:key="event-{{ $event->id }}">
                    <img src="{{ $event->image ? Storage::disk('s3')->temporaryUrl($event->image, now()->addMinutes(5)) : asset('img\university.jpg') }}" alt="Image Événement"
                         class="w-full h-40 object-cover">

                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $event->title }}
                            </h3>

                            @if($canDelete)
                                <div class="flex space-x-2">
                                    <flux:tooltip content="Modifier">
                                        <a href="{{ route('events.edit', $event) }}"
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            <x-heroicon-o-pencil class="w-5 h-5"/>
                                        </a>
                                    </flux:tooltip>
                                    <flux:tooltip content="Supprimer">
                                        @livewire('events.delete', ['event' => $event], key("delete-{$event->id}"))
                                    </flux:tooltip>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center space-x-2 mt-2 text-sm text-gray-600 dark:text-gray-400">
                            <x-heroicon-o-calendar class="w-4 h-4"/>
                            <span>{{ $event->date->translatedFormat('d F Y') }}</span>
                        </div>

                        <div class="flex items-center space-x-2 mt-1 text-sm text-gray-600 dark:text-gray-400">
                            <x-heroicon-o-map-pin class="w-4 h-4"/>
                            <span>{{ $event->location }}</span>
                        </div>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 flex-1">
                            {{ Str::limit($event->description, 100) }}
                        </p>

                        <!-- Lien Lire la suite -->
                        <a href="{{ route('events.show', $event) }}"
                           class="text-blue-600 dark:text-blue-400 font-medium mt-4 inline-block">
                            Voir les détails →
                        </a>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center w-full">
                    <span class="text-gray-500 dark:text-gray-400">Aucun événement trouvé</span>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $events->links() }}
        </div>
    </div>
</div>
