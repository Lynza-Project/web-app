<div class="rounded-xl dark:border-neutral-700 space-y-4">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-slate-800 dark:text-white">Liste des utilisateurs</h3>
        @livewire('search-bar', ['model' => 'search'], key('search-bar'))
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 shadow-sm dark:border-slate-700"
         wire:listener="refreshPlantsTable">
        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300">
            <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-800 dark:text-slate-200">
            <tr class="text-left border-b border-slate-200 dark:border-slate-700">
                <th class="p-4">Actions</th>
                <th class="p-4">Utilisateur</th>
                <th class="p-4">Email</th>
                <th class="p-4">Date de création</th>
                <th class="p-4">Rôle</th>
            </tr>
            </thead>

            <tbody wire:loading.remove wire:target="search" class="bg-white dark:bg-slate-900">
            @forelse ($users as $index => $user)
                <tr wire:key="user-{{ $user->id }}"
                    class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <flux:tooltip content="Voir les détails">
                                @livewire('users.show', ['user' => $user], key("show-{$user->id}-{$index}"))
                            </flux:tooltip>
                            <flux:tooltip content="Modifier">
                                @livewire('users.update', ['user' => $user], key("update-{$user->id}-{$index}"))
                            </flux:tooltip>
                            <flux:tooltip content="Supprimer">
                                @livewire('users.delete', ['user' => $user], key("delete-{$user->id}-{$index}"))
                            </flux:tooltip>
                        </div>
                    </td>

                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                <img src="{{ $user->profile_picture_url }}" alt="{{ $user->first_name[0] }}" class="h-full w-full object-cover">
                            </div>
                            <span class="font-medium text-slate-800 dark:text-white">{{ $user->first_name . ' ' . $user->last_name }}</span>
                        </div>
                    </td>

                    <td class="p-4">{{ $user->email }}</td>
                    <td class="p-4">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="p-4">
                        @php
                            $statuses = [
                                'super-admin' => 'bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-300 dark:border-rose-800/30',
                                'admin' => 'bg-purple-100 text-purple-700 border border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-800/30',
                                'user' => 'bg-indigo-100 text-indigo-700 border border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-800/30',
                            ];
                            $role = $user->role;
                        @endphp
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $statuses[$role] }}">
                                {{ $role }}
                            </span>
                    </td>
                </tr>
            @empty
                <tr wire:key="no-users">
                    <td class="p-4 text-center" colspan="5">
                        <div class="py-8">
                            <p class="text-slate-500 dark:text-slate-400">Aucun utilisateur trouvé</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>

            <tbody wire:loading wire:target="search">
            <tr>
                <td colspan="5" class="py-12 text-center">
                    <div class="flex flex-col items-center justify-center space-y-3">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                            <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                            <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce"></div>
                        </div>
                        <span class="text-sm text-slate-500 dark:text-slate-400">Chargement des utilisateurs...</span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
