@if (request()->routeIs('register'))
    <x-layouts.auth.simple>
        {{ $slot }}
    </x-layouts.auth.simple>
@else
    <x-layouts.auth.split>
        {{ $slot }}
    </x-layouts.auth.split>
@endif

