@php
    use App\Models\Ticket;

    $user = auth()->user();
    $query = Ticket::query();

    // Filter by organization for regular users and admins
    if ($user->role !== 'super-admin') {
        $query->where('organization_id', $user->organization_id);

        // Regular users can only see their own tickets
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }
    }

    $tickets = $query->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
@endphp

<section class="relative w-full max-w-lg mx-auto h-64 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg dark:shadow-none bg-white dark:bg-zinc-900" role="region" aria-label="Tickets récents">
    <div class="p-4 h-full flex flex-col">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tickets récents</h2>
            <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium" aria-label="Voir tous les tickets">
                Voir tous
            </a>
        </div>

        <div class="flex-grow overflow-y-auto" role="region" aria-label="Liste des tickets récents">
            @forelse ($tickets as $ticket)
                @if ($loop->first)
                    <ul class="space-y-2" role="list" aria-label="Tickets récents">
                @endif
                        <li role="listitem">
                            <a href="{{ route('tickets.show', $ticket) }}" class="block p-3 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition" aria-label="Voir le ticket {{ $ticket->subject }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $ticket->subject }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <time datetime="{{ $ticket->created_at->toISOString() }}">{{ $ticket->created_at->format('d/m/Y H:i') }}</time> • {{ $ticket->user->name }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $ticket->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}"
                                          aria-label="Statut du ticket : {{ $ticket->status === 'open' ? 'Ouvert' : 'Fermé' }}"
                                          role="status">
                                        {{ $ticket->status === 'open' ? 'Ouvert' : 'Fermé' }}
                                    </span>
                                </div>
                            </a>
                        </li>
                @if ($loop->last)
                    </ul>
                @endif
            @empty
                <div class="flex items-center justify-center h-full" role="region" aria-label="Aucun ticket disponible">
                    <p class="text-gray-500 dark:text-gray-400 text-center">
                        Aucun ticket disponible.<br>
                        <a href="{{ route('tickets.create') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium mt-2 inline-block" aria-label="Créer un nouveau ticket">
                            Créer un ticket
                        </a>
                    </p>
                </div>
            @endforelse
        </div>

        @if(count($tickets) > 0)
            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('tickets.create') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium inline-flex items-center text-sm" aria-label="Créer un nouveau ticket">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Créer un nouveau ticket
                </a>
            </div>
        @endif
    </div>
</section>
