<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-slate-800 dark:text-white">Liste des tickets</h3>
        <div class="flex space-x-4">
            <div class="relative">
                @livewire('search-bar', ['model' => 'search'], key('search-bar'))
            </div>
            <select wire:model.live="status" id="status" name="status"
                class="block py-2 px-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Tous les statuts</option>
                <option value="open">Ouvert</option>
                <option value="closed">Fermé</option>
            </select>
            <select wire:model.live="perPage" id="perPage" name="perPage"
                class="block py-2 px-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
    </div>

    <div wire:loading.remove wire:key="tickets-index">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tickets as $ticket)
                <div
                    class="flex flex-col bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
                    wire:key="ticket-{{ $ticket->id }}">
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                                {{ $ticket->subject }}
                            </h3>
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $ticket->status === 'open' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300' }}">
                                {{ $ticket->status === 'open' ? 'Ouvert' : 'Fermé' }}
                            </span>
                        </div>

                        <div class="mt-3 space-y-2">
                            <div class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                                <x-heroicon-o-user class="w-4 h-4 text-indigo-500 dark:text-indigo-400"/>
                                <span>{{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}</span>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                                <x-heroicon-o-building-office class="w-4 h-4 text-indigo-500 dark:text-indigo-400"/>
                                <span>{{ $ticket->organization->name }}</span>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                                <x-heroicon-o-calendar class="w-4 h-4 text-indigo-500 dark:text-indigo-400"/>
                                <span>{{ $ticket->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        </div>

                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-3 flex-1">
                            {{ strip_tags(Str::limit($ticket->description)) }}
                        </p>

                        <div class="flex justify-between items-center mt-4">
                            <a href="{{ route('tickets.show', $ticket) }}"
                               class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium inline-flex items-center transition">
                                Voir les détails
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super-admin' || auth()->user()->id === $ticket->user_id)
                                <div class="flex space-x-2">
                                    <flux:tooltip content="Modifier">
                                        <a href="{{ route('tickets.edit', $ticket) }}"
                                           class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition">
                                            <x-heroicon-o-pencil class="w-5 h-5"/>
                                        </a>
                                    </flux:tooltip>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-12 flex flex-col items-center justify-center bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="mt-2 text-slate-500 dark:text-slate-400">Aucun ticket trouvé</span>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $tickets->links() }}
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
                <span class="text-sm text-slate-500 dark:text-slate-400">Chargement des tickets...</span>
            </div>
        </div>
    </div>
</div>
