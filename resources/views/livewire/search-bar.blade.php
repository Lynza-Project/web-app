<div role="search" aria-label="Recherche dans l'application">
    <label for="search-input" class="sr-only">Rechercher du contenu</label>
    <input
        id="search-input"
        type="text"
        wire:model.live="{{ $model }}"
        class="w-full px-4 py-2 text-blue-900 bg-grey-200 dark:bg-grey-800 dark:text-white rounded-lg focus:outline-none focus:ring focus:ring-blue-400 dark:focus:ring-blue-600 border-1 border-gray-300 dark:border-gray-700"
        placeholder="Rechercher..."
        aria-label="Champ de recherche"
        aria-describedby="search-description"
        autocomplete="off"
        wire:input="$dispatch('searchUpdated', [$event.target.value])"
    />
    <div id="search-description" class="sr-only">
        Tapez votre recherche et les résultats apparaîtront automatiquement
    </div>
    <div aria-live="polite" aria-atomic="true" class="sr-only" id="search-status">
        <!-- Les annonces de recherche apparaîtront ici -->
    </div>
</div>
