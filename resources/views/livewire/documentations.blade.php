<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-slate-800 dark:text-white">Liste des documentations</h3>
        <div class="flex space-x-4">
            @livewire('search-bar', ['model' => 'search'], key('search-bar'))
            <select wire:model.live="perPage" id="perPage" name="perPage"
                class="block py-2 px-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option>6</option>
                <option>12</option>
                <option>24</option>
                <option>48</option>
            </select>
        </div>
    </div>

    <div wire:loading.remove wire:key="documentations-index">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($documentations as $documentation)
                <div
                    class="flex flex-col bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
                    wire:key="documentation-{{ $documentation->id }}">
                    <div class="relative h-48 w-full overflow-hidden">
                        <img src="{{ $documentation->image ? Storage::disk('s3')->url($documentation->image) : asset('img/documentation-default.jpg') }}"
                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                                {{ $documentation->title }}
                            </h3>

                            @if($canDelete)
                                <div class="flex space-x-2">
                                    <flux:tooltip content="Modifier">
                                        <a href="{{ route('documentations.edit', $documentation) }}"
                                           class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition">
                                            <x-heroicon-o-pencil class="w-5 h-5"/>
                                        </a>
                                    </flux:tooltip>
                                    <flux:tooltip content="Supprimer">
                                        @livewire('documentations.delete', ['documentation' => $documentation], key("delete-{$documentation->id}"))
                                    </flux:tooltip>
                                </div>
                            @endif
                        </div>

                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-3 flex-1">
                            {{ strip_tags(Str::limit($documentation->content, 100)) }}
                        </p>

                        <!-- Lien Voir les détails -->
                        <a href="{{ route('documentations.show', $documentation) }}"
                           class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium mt-4 inline-flex items-center transition">
                            Voir les détails
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
                    <span class="mt-2 text-slate-500 dark:text-slate-400">Aucune documentation trouvée</span>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $documentations->links() }}
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
                <span class="text-sm text-slate-500 dark:text-slate-400">Chargement des documentations...</span>
            </div>
        </div>
    </div>
</div>
