@php
    use App\Helpers\UserHelper;
@endphp

<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Accueil</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('documentations.index') }}">Documentations</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $documentation->title }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mt-1">
            <a href="{{ route('documentations.index') }}"
               class="inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500 dark:text-indigo-400 group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux documentations
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                <div class="relative h-80 w-full overflow-hidden">
                    <img src="{{ $documentation->image ? Storage::disk('s3')->url($documentation->image) : asset('img/documentation-default.jpg') }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>

                <div class="p-8">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-6">
                        <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                            {{ $documentation->title }}
                        </h1>

                        @if(UserHelper::isAdministrator())
                            <div class="flex space-x-3">
                                <a href="{{ route('documentations.edit', $documentation) }}"
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                    <x-heroicon-o-pencil class="w-4 h-4 mr-2"/>
                                    Modifier
                                </a>

                                @if(UserHelper::isAdministrator())
                                    <flux:modal.trigger name="delete-documentation-{{ $documentation->id }}">
                                        <button type="button" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition shadow-sm">
                                            <x-heroicon-o-trash class="w-4 h-4 mr-2"/>
                                            Supprimer
                                        </button>
                                    </flux:modal.trigger>

                                    <flux:modal name="delete-documentation-{{ $documentation->id }}" class="md:w-[500px] bg-white dark:bg-slate-900 rounded-lg shadow-xl">
                                        <div class="p-6 space-y-6">
                                            <div class="flex items-center space-x-3 text-rose-600 dark:text-rose-400">
                                                <x-heroicon-o-exclamation-triangle class="w-10 h-10"/>
                                                <flux:heading size="lg">Supprimer la documentation</flux:heading>
                                            </div>

                                            <p class="text-slate-700 dark:text-slate-300">
                                                Êtes-vous sûr de vouloir supprimer la documentation <span class="font-semibold">{{ $documentation->title }}</span> ?
                                                <br>
                                                Cette action est irréversible.
                                            </p>

                                            <div class="flex justify-end space-x-3">
                                                <form action="{{ route('documentations.destroy', $documentation) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <flux:button type="submit" variant="danger">
                                                        Supprimer
                                                    </flux:button>
                                                </form>
                                            </div>
                                        </div>
                                    </flux:modal>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 text-slate-700 dark:text-slate-300 leading-relaxed text-lg">
                        {!! $documentation->content !!}
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow duration-300 p-6 h-fit">
                <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-6 pb-3 border-b border-slate-200 dark:border-slate-700">À propos</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Auteur</h3>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <p class="text-slate-800 dark:text-white">{{ $documentation->user->first_name }} {{ $documentation->user->last_name }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Organisation</h3>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <p class="text-slate-800 dark:text-white">{{ $documentation->organization->name }}</p>
                        </div>
                    </div>

                    @if($documentation->created_at !== $documentation->updated_at)
                    <div>
                        <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Dernière modification</h3>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-slate-800 dark:text-white">Le {{ $documentation->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
