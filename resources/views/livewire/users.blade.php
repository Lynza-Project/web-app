<div class="p-6 ">
    @livewire('search-bar', ['model' => 'search', 'width' => 'w-1/3'])

    <div wire:loading class="flex justify-center items-center">
        <div class="flex items-center space-x-2">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-8 w-8"></div>
            <span>Chargement...</span>
        </div>
    </div>

    <div wire:loading.remove>
        <table class="w-full border-collapse">
            <thead>
            <tr class="text-left border-b border-gray-300 dark:border-gray-700">
                <th class="p-3">Actions</th>
                <th class="p-3">
                    Utilisateur
                </th>
                <th class="p-3">
                    Email
                </th>
                <th class="p-3">
                    Date de création
                </th>
                <th class="p-3">
                    Rôle
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="p-3">
                        <flux:modal.trigger name="edit-user-{{ $user->id }}">
                            <flux:button variant="primary">
                                <x-heroicon-o-pencil class="w-4 h-4"/>
                            </flux:button>
                        </flux:modal.trigger>
                        @livewire('users.edit-user', ['id' => $user->id], key($user->id))

                        <flux:modal.trigger name="delete-user-{{ $user->id }}">
                            <flux:button variant="danger">
                                <x-heroicon-o-trash class="w-4 h-4"/>
                            </flux:button>
                        </flux:modal.trigger>

                        <flux:modal name="delete-user-{{ $user->id }}" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Delete user</flux:heading>
                                    <flux:subheading>Are you sure you want to delete this user?</flux:subheading>
                                </div>

                                <div class="flex">
                                    <flux:spacer />

                                    <flux:button type="submit" variant="danger">Delete</flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    </td>
                    <td class="flex items-center p-3">
                        <img src="{{ $user->profile_photo_url }}" alt="P" class="w-8 h-8 rounded-full mr-3">
                        <span class="font-semibold">{{ $user->first_name . ' ' . $user->last_name }}</span>
                    </td>
                    <td class="p-3">
                        {{ $user->email }}
                    </td>
                    <td class="p-3">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
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
                <tr>
                    <td class="p-3 text-center" colspan="5">Aucun utilisateur trouvé</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
    <style>
        .loader {
            border-top-color: #3498db;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</div>

