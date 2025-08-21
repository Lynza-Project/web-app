<x-layouts.app>
    <main id="main-content" class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl" role="main" aria-label="Tableau de bord principal">
        <h1 class="sr-only">Tableau de bord</h1>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch" role="region" aria-label="Widgets du tableau de bord">
            <div class="w-full" role="region" aria-label="Widget de bienvenue">
                @include('widgets.hello')
            </div>

            <div class="w-full" role="region" aria-label="Widget météo">
                @include('widgets.weather')
            </div>

            <div class="w-full" role="region" aria-label="Widget tickets récents">
                @include('widgets.tickets')
            </div>

            <div class="w-full" role="region" aria-label="Widget actualités récentes">
                @include('widgets.actu')
            </div>

            <div class="w-full" role="region" aria-label="Widget événements récents">
                @include('widgets.events')
            </div>

        </section>
    </main>
</x-layouts.app>
