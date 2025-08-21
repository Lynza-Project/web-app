@php use App\Helpers\UserHelper; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <x-theme-styles/>
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<!-- Liens d'évitement pour l'accessibilité -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded z-50">
    Aller au contenu principal
</a>
<a href="#main-navigation" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-32 bg-blue-600 text-white px-4 py-2 rounded z-50">
    Aller à la navigation
</a>

<flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900" role="navigation" aria-label="Navigation principale">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
        <x-app-logo/>
    </a>

    <nav id="main-navigation" aria-label="Menu principal">
        <flux:navlist variant="outline">
            <flux:navlist.group heading="Espaces" class="grid" role="group" aria-labelledby="espaces-heading">
                <h3 id="espaces-heading" class="sr-only">Espaces de navigation</h3>
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                                   wire:navigate aria-label="Aller à l'accueil" :aria-current="request()->routeIs('dashboard') ? 'page' : null">{{ __('Accueil') }}</flux:navlist.item>
                @if(UserHelper::isAdministrator())
                    <flux:navlist.item icon="users" :href="route('users.index')"
                                       :current="request()->routeIs('users.*')"
                                       wire:navigate aria-label="Aller à la gestion des utilisateurs" :aria-current="request()->routeIs('users.*') ? 'page' : null">{{ __('Gestion Utilisateur') }}</flux:navlist.item>
                    <flux:navlist.item icon="paint-brush" :href="route('themes.index')"
                                       :current="request()->routeIs('themes.*')"
                                       wire:navigate aria-label="Aller aux paramètres de thème" :aria-current="request()->routeIs('themes.*') ? 'page' : null">{{ __('Thème') }}</flux:navlist.item>
                @endif
                <flux:navlist.item icon="newspaper" :href="route('actualities.index')"
                                   :current="request()->routeIs('actualities.*')"
                                   wire:navigate aria-label="Aller aux actualités" :aria-current="request()->routeIs('actualities.*') ? 'page' : null">{{ __('Actualités') }}</flux:navlist.item>
                <flux:navlist.item icon="calendar" :href="route('events.index')"
                                   :current="request()->routeIs('events.*')"
                                   wire:navigate aria-label="Aller aux événements" :aria-current="request()->routeIs('events.*') ? 'page' : null">{{ __('Événements') }}</flux:navlist.item>
                <flux:navlist.item icon="book-open" :href="route('documentations.index')"
                                   :current="request()->routeIs('documentations.*')"
                                   wire:navigate aria-label="Aller aux documentations" :aria-current="request()->routeIs('documentations.*') ? 'page' : null">{{ __('Documentations') }}</flux:navlist.item>
                <flux:navlist.item icon="ticket" :href="route('tickets.index')"
                                   :current="request()->routeIs('tickets.*')"
                                   wire:navigate aria-label="Aller aux tickets de support" :aria-current="request()->routeIs('tickets.*') ? 'page' : null">{{ __('Tickets') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>
    </nav>

    <flux:spacer/>

    <flux:navlist variant="outline">
        @impersonating
        <flux:navlist.group heading="Assistance utilisateur" class="grid">
            <flux:navlist.item icon="arrow-left" :href="route('impersonate.leave')">
                {{ __('Quitter l\'assistance') }}
            </flux:navlist.item>
        </flux:navlist.group>
        @endImpersonating

        @if(!UserHelper::isSuperAdministrator())
            <flux:navlist.group heading="Aide" class="grid">
                <flux:navlist.item icon="at-symbol" href="/support" target="_blank">
                    {{ __('Contacter le support') }}
                </flux:navlist.item>
            </flux:navlist.group>
        @endif
        @if(UserHelper::isSuperAdministrator())
            <flux:navlist.group heading="Administration" class="grid">
                <flux:navlist.item icon="shield-check" href="/superadmin" target="_blank">
                    {{ __('Back Office') }}
                </flux:navlist.item>
            </flux:navlist.group>
        @endif
    </flux:navlist>

    <!-- Desktop User Menu -->
    <flux:dropdown position="bottom" align="start" aria-label="Menu utilisateur">
        <flux:profile
            :name="auth()->user()->first_name"
            :avatar="auth()->user()->profile_picture_url"
            icon-trailing="chevrons-up-down"
            aria-label="Ouvrir le menu utilisateur de {{ auth()->user()->first_name }}"
            aria-expanded="false"
            aria-haspopup="true"
        />

        <flux:menu class="w-[220px]" role="menu" aria-label="Options utilisateur">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal" role="presentation">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm" role="presentation">
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                            <img src="{{ auth()->user()->profile_picture_url }}"
                                 alt="Photo de profil de {{ auth()->user()->first_name }}"
                                 class="w-8 h-8 rounded-full mr-3">
                        </span>

                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->first_name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <flux:menu.radio.group>
                <flux:menu.item href="/settings/profile" icon="cog"
                                wire:navigate role="menuitem" aria-label="Aller aux paramètres du profil">{{ __('Paramètres') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full" role="menuitem" aria-label="Se déconnecter de l'application">
                    {{ __('Déconnexion') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>

<!-- Mobile User Menu -->
<flux:header class="lg:hidden" role="banner">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" aria-label="Ouvrir le menu de navigation"/>

    <flux:spacer/>

    <flux:dropdown position="top" align="end" aria-label="Menu utilisateur mobile">
        <flux:profile
            :avatar="auth()->user()->profile_picture_url"
            icon-trailing="chevron-down"
            aria-label="Ouvrir le menu utilisateur de {{ auth()->user()->first_name }}"
            aria-expanded="false"
            aria-haspopup="true"
        />

        <flux:menu role="menu" aria-label="Options utilisateur mobile">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal" role="presentation">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm" role="presentation">
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                            <img src="{{ auth()->user()->profile_picture_url }}"
                                 alt="Photo de profil de {{ auth()->user()->first_name }}"
                                 class="w-8 h-8 rounded-full mr-3">
                        </span>

                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->first_name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <flux:menu.radio.group>
                <flux:menu.item href="/settings/profile" icon="cog" wire:navigate
                                role="menuitem" aria-label="Aller aux paramètres du profil">Paramètres</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full" role="menuitem" aria-label="Se déconnecter de l'application">
                    {{ __('Déconnexion') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

{{ $slot }}

@fluxScripts
</body>
</html>
