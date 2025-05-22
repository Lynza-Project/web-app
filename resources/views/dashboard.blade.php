<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            <div class="w-full">
                @include('widgets.hello')
            </div>

            <div class="w-full">
                @include('widgets.weather')
            </div>


            <div class="relative w-full max-w-lg mx-auto h-64 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg dark:shadow-none bg-white dark:bg-zinc-900">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class="absolute inset-0 flex flex-col justify-center items-center p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Soon 🚀
                    </h2>
                </div>
            </div>

            <div class="w-full">
                @include('widgets.actu')
            </div>

            <div class="w-full">
                @include('widgets.events')
            </div>

        </div>

        <div class="relative h-64 w-full overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg dark:shadow-none bg-white dark:bg-zinc-900">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="absolute inset-0 flex flex-col justify-center items-center p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    Soon 🚀
                </h2>
            </div>
        </div>
    </div>
</x-layouts.app>
