<div x-data="{ weather: null }"
     x-init="fetch('https://api.open-meteo.com/v1/forecast?latitude=45.7485&longitude=4.8467&models=meteofrance_seamless&current=temperature_2m,weather_code&forecast_days=1')
            .then(response => response.json())
            .then(data => {
                weather = {
                    temperature: data.current.temperature_2m,
                    weathercode: data.current.weather_code
                };
            })"
     class="relative w-full max-w-lg mx-auto h-64 flex flex-col justify-between items-center p-6 bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-lg dark:shadow-none overflow-hidden">

    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
        🌤️ Météo du jour
    </h2>

    <p class="text-gray-600 dark:text-gray-300 text-sm text-center">
        Lyon, France
    </p>

    <!-- Bloc Météo -->
    <div class="flex flex-col items-center">
        <!-- Température et Icône -->
        <div class="flex items-center">
            <template x-if="weather">
                <img :src="'https://openweathermap.org/img/wn/' + getWeatherIcon(weather.weathercode) + '@2x.png'"
                     class="w-12 h-12" alt="Icône Météo">
            </template>
            <span class="text-3xl font-bold text-gray-900 dark:text-gray-100" x-text="weather.temperature + '°C'"></span>
        </div>

        <p class="text-gray-600 dark:text-gray-300 text-sm mt-2" x-text="getWeatherDescription(weather.weathercode)"></p>
    </div>

    <script>
        function getWeatherDescription(code) {
            const descriptions = {
                0: 'Ciel dégagé ☀️',
                1: 'Principalement dégagé 🌤️',
                2: 'Partiellement nuageux ⛅',
                3: 'Nuageux ☁️',
                45: 'Brouillard 🌫️',
                48: 'Brouillard givrant ❄️',
                51: 'Bruine légère 🌦️',
                53: 'Bruine 🌧️',
                55: 'Forte bruine 🌧️',
                61: 'Pluie légère 🌧️',
                63: 'Pluie 🌧️',
                65: 'Pluie forte ⛈️',
                71: 'Neige légère ❄️',
                73: 'Neige 🌨️',
                75: 'Neige forte ❄️❄️',
                80: 'Averses légères 🌦️',
                81: 'Averses 🌧️',
                82: 'Averses fortes ⛈️',
            };
            return descriptions[code] || 'Météo inconnue';
        }

        function getWeatherIcon(code) {
            const icons = {
                0: '01d', 1: '01d', 2: '02d', 3: '03d',
                45: '50d', 48: '50d', 51: '09d', 53: '09d',
                55: '09d', 61: '10d', 63: '10d', 65: '10d',
                71: '13d', 73: '13d', 75: '13d', 80: '09d',
                81: '09d', 82: '09d'
            };
            return icons[code] || '01d';
        }
    </script>
</div>
