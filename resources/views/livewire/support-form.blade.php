<div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-zinc-700">
    @if ($success)
        <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 mb-6"
             role="alert" aria-live="polite" aria-atomic="true">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 dark:text-green-400">
                        <strong>Succès :</strong> Votre demande de support a été envoyée avec succès. Un email de confirmation vous a été envoyé.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form class="space-y-6" wire:submit="send" role="form" aria-label="Formulaire de demande de support">
        <fieldset class="space-y-6">
            <legend class="sr-only">Informations de la demande de support</legend>

            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                    Titre <span class="text-red-500" aria-label="obligatoire">*</span>
                </label>
                <input type="text"
                       id="title"
                       wire:model="title"
                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                       placeholder="Résumé de votre demande"
                       aria-required="true"
                       aria-describedby="@error('title') title-error @enderror title-help"
                       @error('title') aria-invalid="true" @else aria-invalid="false" @enderror>
                <div id="title-help" class="sr-only">Saisissez un titre court et descriptif pour votre demande</div>
                @error('title')
                    <p id="title-error" class="mt-1 text-sm text-red-600 dark:text-red-400" role="alert" aria-live="polite">
                        <strong>Erreur :</strong> {{ $message }}
                    </p>
                @enderror
            </div>

            @error('email')
                <div role="alert" aria-live="polite" class="mt-1 text-sm text-red-600 dark:text-red-400">
                    <strong>Erreur email :</strong> {{ $message }}
                </div>
            @enderror

            <div>
                <label for="category" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                    Catégorie <span class="text-red-500" aria-label="obligatoire">*</span>
                </label>
                <select id="category"
                        wire:model="category"
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        aria-required="true"
                        aria-describedby="@error('category') category-error @enderror category-help"
                        @error('category') aria-invalid="true" @else aria-invalid="false" @enderror>
                    <option value="">Sélectionnez une catégorie</option>
                    <option value="bug">Bug</option>
                    <option value="improvement">Demande d'amélioration</option>
                    <option value="question">Question</option>
                </select>
                <div id="category-help" class="sr-only">Choisissez la catégorie qui correspond le mieux à votre demande</div>
                @error('category')
                    <p id="category-error" class="mt-1 text-sm text-red-600 dark:text-red-400" role="alert" aria-live="polite">
                        <strong>Erreur :</strong> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                    Description du problème/de la demande <span class="text-red-500" aria-label="obligatoire">*</span>
                </label>
                <textarea id="description"
                          wire:model="description"
                          rows="6"
                          class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                          placeholder="Décrivez votre problème ou votre demande en détail..."
                          aria-required="true"
                          aria-describedby="@error('description') description-error @enderror description-help"
                          @error('description') aria-invalid="true" @else aria-invalid="false" @enderror></textarea>
                <div id="description-help" class="sr-only">Décrivez votre problème ou demande de manière détaillée pour nous aider à mieux vous assister</div>
                @error('description')
                    <p id="description-error" class="mt-1 text-sm text-red-600 dark:text-red-400" role="alert" aria-live="polite">
                        <strong>Erreur :</strong> {{ $message }}
                    </p>
                @enderror
            </div>
        </fieldset>

        <div class="flex justify-center">
            <button type="submit"
                    class="bg-indigo-600 text-white py-2 px-5 rounded-lg hover:bg-indigo-700 transition text-base font-medium"
                    aria-describedby="submit-help"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed">
                <span wire:loading.remove>Envoyer la demande</span>
                <span wire:loading aria-live="polite">Envoi en cours...</span>
            </button>
            <div id="submit-help" class="sr-only">Cliquez pour envoyer votre demande de support</div>
        </div>
    </form>
</div>
