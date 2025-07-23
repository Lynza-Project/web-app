<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Accueil</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('users.index') }}">Annuaire des utilisateurs</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Import d'utilisateurs</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gradient-to-r from-indigo-50 to-slate-50 border border-indigo-100 text-slate-700 px-6 py-4 rounded-xl shadow-sm dark:bg-indigo-900/20 dark:text-indigo-100 dark:border-indigo-800/30">
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xl">📥</span>
                <h2 class="font-semibold text-lg text-slate-800 dark:text-white">Import d'utilisateurs</h2>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-300 ml-9">
                Importez plusieurs utilisateurs à la fois à partir d'un fichier Excel. Vous pourrez vérifier et modifier les données avant de créer les comptes.
            </p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            @if (session()->has('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800/30">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if (!$showPreview)
                <div class="mb-6">
                    <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-lg mb-6 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-800/30">
                        <p>L'import affichera les utilisateurs à créer et vous demandera une confirmation avant de procéder.</p>
                    </div>

                    <form wire:submit.prevent="uploadFile">
                        <div class="mb-4">
                            <flux:label for="file">Fichier Excel</flux:label>
                            <flux:input id="file" type="file" wire:model="file" accept=".xlsx,.xls,.csv" />
                            @error('file') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end">
                            <flux:button type="submit" color="primary">
                                Charger le fichier
                            </flux:button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mb-6">
                    <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-lg mb-6 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-800/30">
                        <p>Vérifiez les informations des utilisateurs ci-dessous. Vous pouvez modifier les valeurs ou supprimer des utilisateurs avant de procéder à la création.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300">
                            <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-800 dark:text-slate-200">
                                <tr class="text-left border-b border-slate-200 dark:border-slate-700">
                                    <th class="p-4">Prénom</th>
                                    <th class="p-4">Nom</th>
                                    <th class="p-4">Email</th>
                                    <th class="p-4">Rôle</th>
                                    <th class="p-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-900">
                                @forelse ($users as $index => $user)
                                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                        <td class="p-4">
                                            <flux:input wire:model="users.{{ $index }}.first_name" />
                                        </td>
                                        <td class="p-4">
                                            <flux:input wire:model="users.{{ $index }}.last_name" />
                                        </td>
                                        <td class="p-4">
                                            <flux:input wire:model="users.{{ $index }}.email" />
                                        </td>
                                        <td class="p-4">
                                            <flux:select wire:model="users.{{ $index }}.role">
                                                <option value="user">Utilisateur</option>
                                                <option value="admin">Admin</option>
                                            </flux:select>
                                        </td>
                                        <td class="p-4">
                                            <flux:button wire:click="removeUser({{ $index }})" color="danger" size="sm">
                                                Supprimer
                                            </flux:button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-4 text-center">
                                            <div class="py-8">
                                                <p class="text-slate-500 dark:text-slate-400">Aucun utilisateur trouvé dans le fichier</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end">
                    <flux:button wire:click="createUsers" color="primary">
                        Lancer la création
                    </flux:button>
                </div>
            @endif
        </div>
    </div>
