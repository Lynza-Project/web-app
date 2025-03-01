<div
    class="relative flex flex-col justify-center items-center p-6 bg-white dark:bg-gray-900 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-md">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
        Bienvenue, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
        <span id="wave-emoji" class="cursor-pointer">👋</span>
    </h2>
    <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
        Nous sommes le <span class="font-semibold">{{ now()->translatedFormat('l d F Y') }}</span>.
        Passez une excellente journée !
    </p>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const waveEmoji = document.querySelector("#wave-emoji");

        if (waveEmoji) {
            waveEmoji.addEventListener("mouseenter", function (event) {
                const x = event.clientX / window.innerWidth;
                const y = event.clientY / window.innerHeight;

                confetti({
                    particleCount: 200,
                    spread: 200,
                    startVelocity: 30,
                    origin: { x: x, y: y },
                    colors: ["#007bff", "#00aaff", "#00ccff", "#3399ff", "#66ccff", "#99ddff", "#cceeff"]
                });
            });
        }
    });
</script>

