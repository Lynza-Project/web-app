<div>
    <div class="space-y-6 mb-6">
        @forelse ($messages as $message)
            <div class="flex space-x-4 {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="flex-shrink-0 {{ $message->user_id === auth()->id() ? 'order-last' : 'order-first' }}">
                    <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                        <span class="text-gray-700 dark:text-gray-300 font-medium">
                            {{ substr($message->user->first_name, 0, 1) . substr($message->user->last_name, 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col max-w-lg {{ $message->user_id === auth()->id() ? 'items-end' : 'items-start' }}">
                    <div class="px-4 py-2 rounded-lg {{ $message->user_id === auth()->id() ? 'bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' }}">
                        <div class="text-sm">
                            {{ $message->content }}
                        </div>
                    </div>
                    <div class="mt-1 flex items-center text-xs text-gray-500 dark:text-gray-400">
                        <span>{{ $message->user->name }}</span>
                        <span class="mx-1">•</span>
                        <span>{{ $message->created_at->format('d/m/Y H:i') }}</span>

                        @if ($this->canManageMessage($message))
                            <button wire:click="deleteMessage({{ $message->id }})" class="ml-2 text-red-500 hover:text-red-700" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                Aucun message dans cette conversation. Soyez le premier à écrire !
            </div>
        @endforelse
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <form wire:submit.prevent="addMessage">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nouveau message</label>
            <div class="mt-1">
                <textarea id="content" wire:model="content" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-5" placeholder="Écrivez votre message ici..."></textarea>
                @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mt-2 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Envoyer
                </button>
            </div>
        </form>
    </div>
</div>
