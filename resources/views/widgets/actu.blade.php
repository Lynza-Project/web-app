@php
    use App\Models\Actuality;
    $actualities = Actuality::where('organization_id', auth()->user()->organization_id)
        ->orderBy('created_at', 'desc')
        ->limit(4)
        ->get();
@endphp
<div x-data="{ current: 0, total: {{ count($actualities) }} }"
     class="relative w-full max-w-lg mx-auto h-64 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg dark:shadow-none bg-white dark:bg-zinc-900">
    <div class="flex transition-transform duration-500 ease-in-out"
         :style="'transform: translateX(-' + (current * 100) + '%)'">

        @foreach ($actualities as $item)
            <div
                class="w-full flex-shrink-0 h-64 p-6 bg-white dark:bg-zinc-900 flex flex-col justify-between">
                <div class="flex-grow">
                    <h3 class="text-lg font-semibold text-grey-900 dark:text-white">{{ $item->title }}</h3>
                    <p class="text-sm text-grey-600 dark:text-grey-400 mt-2">{{ Str::limit($item->content) }}</p>
                </div>
                <img src="{{ asset('img/university.jpg') }}" alt="Actuality"
                     class="w-64 h-32 object-cover rounded-xl mt-4 mx-auto">
                <a href="{{ route('actualities.show', $item) }}" class="text-blue-600 dark:text-blue-400 font-medium mt-auto text-right">
                    Lire la suite →
                </a>
            </div>
        @endforeach
    </div>

    <button @click="current = (current === 0) ? total - 1 : current - 1"
            class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white dark:bg-zinc-800 p-2 rounded-full shadow-md">
        <x-heroicon-o-chevron-left class="w-5 h-5 text-gray-900 dark:text-white"/>
    </button>

    <button @click="current = (current === total - 1) ? 0 : current + 1"
            class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white dark:bg-zinc-800 p-2 rounded-full shadow-md">
        <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-900 dark:text-white"/>
    </button>
</div>
