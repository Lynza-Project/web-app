<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-zinc-800 dark:text-zinc-200">
                {{ __('Thème de l\'organisation') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Accueil</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Thème</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gradient-to-r from-indigo-50 to-slate-50 border border-indigo-100 text-slate-700 px-6 py-4 rounded-xl shadow-sm dark:bg-indigo-900/20 dark:text-indigo-100 dark:border-indigo-800/30">
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xl">🎨</span>
                <h2 class="font-semibold text-lg text-slate-800 dark:text-white">Personnalisation du thème</h2>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-300 ml-9">
                Personnalisez l'apparence de votre intranet en modifiant les couleurs et en ajoutant votre logo. Ces changements seront appliqués à l'ensemble de votre organisation.
            </p>
        </div>

        <div class="py-6">
            <div>
                <div class="overflow-hidden bg-white shadow-sm dark:bg-zinc-800 sm:rounded-lg">
                    <div class="p-6 text-zinc-900 dark:text-zinc-100">
                        @if(!$theme)
                            <!-- No theme exists, show create form -->
                            @if($canManage)
                                <div class="flex flex-col items-center justify-center py-12">
                                    <p class="mb-4 text-lg font-medium text-zinc-500 dark:text-zinc-400">
                                        {{ __('Aucun thème n\'a été configuré pour votre organisation.') }}
                                    </p>
                                    <div class="w-full max-w-3xl">
                                        <livewire:themes.create />
                                    </div>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-12">
                                    <p class="mb-4 text-lg font-medium text-zinc-500 dark:text-zinc-400">
                                        {{ __('Aucun thème n\'a été configuré pour votre organisation. Veuillez contacter un administrateur.') }}
                                    </p>
                                </div>
                            @endif
                        @else
                            <!-- Theme exists, show edit form -->
                            @if($canManage)
                                <livewire:themes.edit :theme="$theme" />
                            @else
                                <div class="space-y-6">
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">{{ $theme->title }}</h3>

                                    <div class="flex justify-center">
                                        <div class="flex flex-col items-center">
                                            <div class="h-12 w-12 rounded-full bg-{{ $theme->primary }}"></div>
                                            <span class="mt-1 text-sm">Primary</span>
                                        </div>
                                    </div>

                                    @if($theme->logo_path)
                                        <div class="mt-4 flex justify-center">
                                            <img src="{{ Storage::disk('s3')->url($theme->logo_path) }}" alt="{{ $theme->title }}" class="h-24 object-contain">
                                        </div>
                                    @endif

                                    <p class="text-center text-zinc-500 dark:text-zinc-400">
                                        {{ __('Seuls les administrateurs peuvent modifier le thème de l\'organisation.') }}
                                    </p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
