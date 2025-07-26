<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            <div class="w-full">
                @include('widgets.hello')
            </div>

            <div class="w-full">
                @include('widgets.weather')
            </div>

            <div class="w-full">
                @include('widgets.tickets')
            </div>

            <div class="w-full">
                @include('widgets.actu')
            </div>

            <div class="w-full">
                @include('widgets.events')
            </div>

        </div>
    </div>
</x-layouts.app>
