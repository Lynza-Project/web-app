@php use App\Helpers\UserHelper; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
        <x-app-logo/>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.group heading="Espaces" class="grid">
            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                               wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            @if(UserHelper::isAdministrator())
                <flux:navlist.item icon="users" :href="route('users.index')"
                                   :current="request()->routeIs('users.index')"
                                   wire:navigate>{{ __('Annuaire des utilisateurs') }}</flux:navlist.item>
            @endif
            <flux:navlist.item icon="newspaper" :href="route('actualities.index')"
                               :current="request()->routeIs('actualities.*')"
                               wire:navigate>{{ __('Actualités') }}</flux:navlist.item>
            <flux:navlist.item icon="calendar" :href="route('events.index')"
                               :current="request()->routeIs('events.*')"
                               wire:navigate>{{ __('Événements') }}</flux:navlist.item>
            <flux:navlist.item icon="book-open" :href="route('documentations.index')"
                               :current="request()->routeIs('documentations.*')"
                               wire:navigate>{{ __('Documentations') }}</flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer/>

    <flux:navlist variant="outline">
        @if(UserHelper::isSuperAdministrator())
            <flux:navlist.group heading="Administration" class="grid">
                <flux:navlist.item icon="shield-check" href="/superadmin" target="_blank" class="text-red">
                    {{ __('Back Office') }}
                </flux:navlist.item>
            </flux:navlist.group>
        @endif
    </flux:navlist>

    <!-- Desktop User Menu -->
    <flux:dropdown position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->first_name"
            :avatar="auth()->user()->profile_picture"
            icon-trailing="chevrons-up-down"
        />

        <flux:menu class="w-[220px]">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <img src="{{ auth()->user()->profile_picture }}" alt="P"
                                         class="w-8 h-8 rounded-full mr-3">
                                </span>
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
                                wire:navigate>{{ __('Paramètres') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Déconnexion') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>

<!-- Mobile User Menu -->
<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

    <flux:spacer/>

    <flux:dropdown position="top" align="end">
        <flux:profile
            :avatar="auth()->user()->profile_picture"
            icon-trailing="chevron-down"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <img src="{{ auth()->user()->profile_picture }}" alt="P"
                                         class="w-8 h-8 rounded-full mr-3">
                                </span>

                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <flux:menu.radio.group>
                <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Paramètres</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
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
