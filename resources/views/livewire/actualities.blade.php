<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-slate-800 dark:text-white">Liste des actualités</h3>
        @livewire('search-bar', ['model' => 'search'], key('search-bar'))
    </div>

    <div wire:loading.remove wire:key="actualities-index">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($actualities as $actuality)
                <div
                    class="flex flex-col bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
                    wire:key="actuality-{{ $actuality->id }}">
                    <div class="relative h-48 w-full overflow-hidden">
                        <img src="{{ $actuality->image ? Storage::disk('s3')->temporaryUrl($actuality->image, now()->addMinutes(5)) : asset('img\university.jpg') }}" alt="Image Actualité"
                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        <div class="absolute bottom-3 left-4">
                            <span class="px-2.5 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 rounded-full">
                                {{ $actuality->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                                {{ $actuality->title }}
                            </h3>

                            @if($canDelete)
                                <div class="flex space-x-2">
                                    <flux:tooltip content="Modifier">
                                        <a href="{{ route('actualities.edit', $actuality) }}"
                                           class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition">
                                            <x-heroicon-o-pencil class="w-5 h-5"/>
                                        </a>
                                    </flux:tooltip>
                                    <flux:tooltip content="Supprimer">
                                        @livewire('actualities.delete', ['actuality' => $actuality], key("delete-{$actuality->id}"))
                                    </flux:tooltip>
                                </div>
                            @endif
                        </div>

                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-3 flex-1">
                            {{ Str::limit($actuality->content, 120) }}
                        </p>

                        <!-- Lien Lire la suite -->
                        <a href="{{ route('actualities.show', $actuality) }}"
                           class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium mt-4 inline-flex items-center transition">
                            Lire la suite
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-12 flex flex-col items-center justify-center bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="mt-2 text-slate-500 dark:text-slate-400">Aucune actualité trouvée</span>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $actualities->links() }}
        </div>
    </div>

    <div wire:loading wire:target="search">
        <div class="py-12 text-center">
            <div class="flex flex-col items-center justify-center space-y-3">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                    <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                    <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce"></div>
                </div>
                <span class="text-sm text-slate-500 dark:text-slate-400">Chargement des actualités...</span>
            </div>
        </div>
    </div>
</div>
