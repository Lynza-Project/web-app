<div
    class="relative w-full max-w-lg mx-auto h-64 flex flex-col justify-center items-center p-6 bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-zinc-700 shadow-lg dark:shadow-none overflow-hidden">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
        Bienvenue, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
        <span id="wave-emoji" class="cursor-pointer">👋</span>
    </h2>
    <p class="text-gray-600 dark:text-gray-300 text-sm mt-2 text-center">
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
