<div>
    <flux:modal.trigger name="show-user-{{ $user->id }}">
        <flux:icon name="information-circle" class="cursor-pointer text-blue-600"/>
    </flux:modal.trigger>
    <flux:modal name="show-user-{{ $user->id }}" class="md:w-[600px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Détails de l'utilisateur</flux:heading>
                <flux:subheading>Informations sur {{ $user->first_name . ' ' . $user->last_name }}</flux:subheading>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="{{ $user->profile_picture }}" alt="Profile" class="w-16 h-16 rounded-full">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $user->first_name . ' ' . $user->last_name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Rôle</h4>
                            <p class="mt-1">
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
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Date de création</h4>
                            <p class="mt-1 text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Dernière mise à jour</h4>
                            <p class="mt-1 text-gray-900">{{ $user->updated_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Organisation</h4>
                            <p class="mt-1 text-gray-900">{{ $user->organization->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </flux:modal>
</div>
