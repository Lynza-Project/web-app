@php
    use App\Models\Event;
    $events = Event::where('organization_id', auth()->user()->organization_id)
        ->orderBy('created_at', 'desc')
        ->limit(4)
        ->get();
@endphp
<div class="mb-6">
    <div x-data="{ current: 0, total: {{ count($events) }} }"
         class="relative w-full max-w-lg mx-auto h-72 overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm bg-white dark:bg-slate-900">
        <div class="flex transition-transform duration-500 ease-in-out"
             :style="'transform: translateX(-' + (current * 100) + '%)'">

            @foreach ($events as $item)
                <div class="w-full flex-shrink-0 h-72 bg-white dark:bg-slate-900 flex flex-col">
                    <div class="relative h-32 w-full overflow-hidden">
                        <img src="{{ asset('img/event-default.jpg') }}" alt="Event"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        <div class="absolute bottom-3 left-4 right-4">
                            <span class="px-2.5 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 rounded-full">
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4 flex-grow flex flex-col">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white">{{ $item->title }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-2 flex-grow">{{ Str::limit($item->content, 100) }}</p>
                        <a href="{{ route('events.show', $item) }}"
                           class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium mt-2 inline-flex items-center">
                            Découvrir
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <button @click="current = (current === 0) ? total - 1 : current - 1"
                class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white/80 dark:bg-slate-800/80 p-2 rounded-full shadow-sm hover:bg-white hover:shadow-md dark:hover:bg-slate-800 transition">
            <x-heroicon-o-chevron-left class="w-5 h-5 text-slate-700 dark:text-white"/>
        </button>

        <button @click="current = (current === total - 1) ? 0 : current + 1"
                class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white/80 dark:bg-slate-800/80 p-2 rounded-full shadow-sm hover:bg-white hover:shadow-md dark:hover:bg-slate-800 transition">
            <x-heroicon-o-chevron-right class="w-5 h-5 text-slate-700 dark:text-white"/>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-3 left-0 right-0 flex justify-center space-x-2">
            @php $eventsCount = count($events); @endphp
            @for ($i = 0; $i < $eventsCount; $i++)
                <button @click="current = {{ $i }}"
                        :class="{'bg-indigo-600': current === {{ $i }}, 'bg-slate-300 dark:bg-slate-600': current !== {{ $i }}}"
                        class="w-2 h-2 rounded-full transition-colors duration-200"></button>
            @endfor
        </div>
    </div>
</div>
