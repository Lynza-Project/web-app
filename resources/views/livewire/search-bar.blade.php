    <input
        type="text"
        wire:model.live="{{ $model }}"
        class="w-full px-4 py-2 text-blue-900 bg-grey-200 dark:bg-grey-800 dark:text-white rounded-lg focus:outline-none focus:ring focus:ring-blue-400 dark:focus:ring-blue-600 border-1 border-gray-300 dark:border-gray-700"
        placeholder="🔍 Rechercher..."
        wire:input="$dispatch('searchUpdated', [$event.target.value])"
    />
