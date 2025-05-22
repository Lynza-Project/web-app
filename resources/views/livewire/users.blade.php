<div class="rounded-xl dark:border-neutral-700">
    @livewire('search-bar', ['model' => 'search', 'width' => 'w-1/3'], key('search-bar'))

    <div class="relative overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700"
         wire:listener="refreshPlantsTable">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs uppercase bg-gray-50 dark:bg-zinc-700 dark:text-gray-300">
            <tr class="text-left border-b border-gray-300 dark:border-gray-700">
                <th class="p-3">Actions</th>
                <th class="p-3">Utilisateur</th>
                <th class="p-3">Email</th>
                <th class="p-3">Date de création</th>
                <th class="p-3">Rôle</th>
            </tr>
            </thead>

            <tbody wire:loading.remove wire:target="search">
            @forelse ($users as $index => $user)
                <tr wire:key="user-{{ $user->id }}"
                    class="border-b border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="p-3">
                        <div class="flex items-center space-x-4">
                            <flux:tooltip content="Voir les détails">
                                <a href="#">
                                    <flux:icon name="information-circle" class="cursor-pointer text-blue-600" />
                                </a>
                            </flux:tooltip>
                            <flux:tooltip content="Modifier">
                                @livewire('users.update', ['user' => $user], key("update-{$user->id}-{$index}"))
                            </flux:tooltip>
                            <flux:tooltip content="Supprimer">
                                @livewire('users.delete', ['user' => $user], key("delete-{$user->id}-{$index}"))
                            </flux:tooltip>
                        </div>
                    </td>

                    <td class="p-3">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $user->profile_picture }}" alt="P" class="w-8 h-8 rounded-full">
                            <span class="font-semibold">{{ $user->first_name . ' ' . $user->last_name }}</span>
                        </div>
                    </td>

                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="p-3">
                        @php
                            $statuses = [
                                'super-admin' => 'bg-red-100 text-red-700 dark:bg-red-600 dark:text-white',
                                'admin' => 'bg-pink-100 text-pink-700 dark:bg-pink-600 dark:text-white',
                                'user' => 'bg-blue-100 text-blue-700 dark:bg-blue-600 dark:text-white',
                            ];
                            $role = $user->role;
                        @endphp
                        <span class="px-2 py-1 text-sm font-semibold rounded-lg {{ $statuses[$role] }}">
                                {{ $role }}
                            </span>
                    </td>
                </tr>
            @empty
                <tr wire:key="no-users">
                    <td class="p-3 text-center" colspan="5">Aucun utilisateur trouvé</td>
                </tr>
            @endforelse
            </tbody>

            <tbody wire:loading wire:target="search">
            <tr>
                <td colspan="5" class="py-10 text-center">
                    <div class="flex flex-col items-center justify-center space-y-3">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                            <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                            <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce"></div>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-300">Chargement des utilisateurs...</span>
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
