<div>
    <flux:modal.trigger name="show-user-{{ $user->id }}">
        <flux:icon name="information-circle" class="cursor-pointer text-blue-600"/>
    </flux:modal.trigger>
    <flux:modal name="show-user-{{ $user->id }}" class="md:w-[600px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Détails de l'utilisateur</flux:heading>
            </div>

            <div class="flex items-center space-x-4 mb-8 border-b pb-6">
                <img src="{{ $user->profile_picture_url }}" alt="Profile" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $user->first_name . ' ' . $user->last_name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    @php
                        $statuses = [
                            'super-admin' => 'red',
                            'admin' => 'pink',
                            'user' => 'blue',
                        ];
                        $roleName = match ($user->role) {
                            'super-admin' => 'Super Admin',
                            'admin' => 'Admin',
                            default => 'Utilisateur',
                        };
                    @endphp
                    <flux:badge color="{{ $statuses[$user->role] }}">
                        {{ $roleName }}
                    </flux:badge>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex flex-col">
                    <h4 class="text-sm font-medium uppercase text-gray-500 mb-1">Date de création</h4>
                    <p class="text-gray-900 font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="flex flex-col">
                    <h4 class="text-sm font-medium uppercase text-gray-500 mb-1">Dernière mise à jour</h4>
                    <p class="text-gray-900 font-medium">{{ $user->updated_at->format('d/m/Y') }}</p>
                </div>
                <div class="flex flex-col">
                    <h4 class="text-sm font-medium uppercase text-gray-500 mb-1">Organisation</h4>
                    <p class="text-gray-900 font-medium">{{ $user->organization->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </flux:modal>
</div>
