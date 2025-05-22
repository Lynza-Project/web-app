<div>
    @livewire('search-bar', ['model' => 'search', 'width' => 'w-1/3'], key('search-bar'))

    <div wire:loading.remove wire:key="actualities-index">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($actualities as $actuality)
                <div
                    class="flex flex-col bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-md overflow-hidden">
                    <img src="{{ asset($actuality->image ?? 'img\university.jpg') }}" alt="Image Actualité"
                         class="w-full h-40 object-cover">

                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $actuality->title }}
                            </h3>

                            @if($canDelete)
                                <div class="flex space-x-2">
                                    <a href="{{ route('actualities.edit', $actuality) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <x-heroicon-o-pencil class="w-5 h-5"/>
                                    </a>
                                    @livewire('actualities.delete', ['actuality' => $actuality], key("delete-{$actuality->id}"))
                                </div>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 flex-1">
                            {{ Str::limit($actuality->content, 120) }}
                        </p>

                        <!-- Lien Lire la suite -->
                        <a href="{{ route('actualities.show', $actuality) }}"
                           class="text-blue-600 dark:text-blue-400 font-medium mt-4 inline-block">
                            Lire la suite →
                        </a>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center w-full">
                    <span class="text-gray-500 dark:text-gray-400">Aucune actualité trouvée</span>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $actualities->links() }}
        </div>
    </div>
</div>
