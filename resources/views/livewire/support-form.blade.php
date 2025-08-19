<div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-zinc-700">
    @if ($success)
        <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 dark:text-green-400">
                        Votre demande de support a été envoyée avec succès. Un email de confirmation vous a été envoyé.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form class="space-y-6" wire:submit="send">
        <div>
            <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Titre</label>
            <input type="text" id="title" wire:model="title" class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Résumé de votre demande">
            @error('title') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        @error('email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

        <div>
            <label for="category" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Catégorie</label>
            <select id="category" wire:model="category" class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                <option value="">Sélectionnez une catégorie</option>
                <option value="bug">Bug</option>
                <option value="improvement">Demande d'amélioration</option>
                <option value="question">Question</option>
            </select>
            @error('category') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description du problème/de la demande</label>
            <textarea id="description" wire:model="description" rows="6" class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Décrivez votre problème ou votre demande en détail..."></textarea>
            @error('description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-center">
            <button type="submit" class="bg-indigo-600 text-white py-2 px-5 rounded-lg hover:bg-indigo-700 transition text-base font-medium">
                <span wire:loading.remove>Envoyer la demande</span>
                <span wire:loading>Envoi en cours...</span>
            </button>
        </div>
    </form>
</div>
