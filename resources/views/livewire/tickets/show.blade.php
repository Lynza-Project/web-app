<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-6">
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
            {{ $ticket->subject }}
        </h1>

        @if ($canManage && $ticket->status === 'open')
            <div class="flex space-x-3">
                <button wire:click="updateStatus" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    <x-heroicon-o-check class="w-4 h-4 mr-2"/>
                    Cloturer
                </button>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @else
            <span class="px-3 py-1.5 text-sm font-medium rounded-full {{ $ticket->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                {{ $ticket->status === 'open' ? 'Ouvert' : 'Fermé' }}
            </span>
        @endif
    </div>

    <div class="flex flex-col space-y-3 mb-6 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-100 dark:border-slate-700/50">
        <div class="flex items-center text-slate-700 dark:text-slate-300">
            <x-heroicon-o-user class="w-5 h-5 mr-2 text-indigo-500 dark:text-indigo-400"/>
            <span>{{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}</span>
        </div>

        <div class="flex items-center text-slate-700 dark:text-slate-300">
            <x-heroicon-o-building-office class="w-5 h-5 mr-2 text-indigo-500 dark:text-indigo-400"/>
            <span>{{ $ticket->organization->name }}</span>
        </div>

        <div class="flex items-center text-slate-700 dark:text-slate-300">
            <x-heroicon-o-calendar class="w-5 h-5 mr-2 text-indigo-500 dark:text-indigo-400"/>
            <span>{{ $ticket->created_at->format('d/m/Y à H:i') }}</span>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-4">Description</h2>
        <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed">
            {!! $ticket->description !!}
        </div>
    </div>

    <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
        <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-4">Conversation</h2>
        <livewire:tickets.messages :ticket="$ticket" />
    </div>
</div>
