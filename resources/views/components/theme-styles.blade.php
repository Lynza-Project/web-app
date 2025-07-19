@php
    use App\Models\Theme;

    $organization = auth()->check() ? auth()->user()->organization : null;
    $theme = $organization ? $organization->themes()->latest()->first() : null;

    // Default theme values as fallback
    $defaults = [
        'primary' => 'blue-500',
        'font' => 'Inter',
        'background_color' => 'white',
        'button_color' => 'blue-500',
    ];

    // Convert Tailwind color names to hex values
    $primaryHex = $theme ? Theme::getHexFromTailwindColor($theme->primary) : Theme::getHexFromTailwindColor($defaults['primary']);
    // For background color, explicitly handle 'white' as a special case
    $backgroundHex = $theme && $theme->background_color ?
        ($theme->background_color === 'white' ? '#ffffff' : Theme::getHexFromTailwindColor($theme->background_color))
        : '#ffffff';
    $buttonHex = $theme && $theme->button_color ? Theme::getHexFromTailwindColor($theme->button_color) : $primaryHex;
@endphp

<style>
    :root {
        --primary: {{ $primaryHex }};
        --font: "{{ $theme->font ?? $defaults['font'] }}", sans-serif;
        --background-color: {{ $backgroundHex }};
        --button-color: {{ $buttonHex }};

        /* Override accent colors with theme primary color */
        --color-accent: {{ $primaryHex }} !important;
        --color-accent-content: {{ $theme ? Theme::getHexFromTailwindColor(str_replace('500', '600', $theme->primary)) : Theme::getHexFromTailwindColor(str_replace('500', '600', $defaults['primary'])) }} !important;
        --color-accent-foreground: var(--color-white) !important;

        /* Override Tailwind color variables directly */
        --color-blue-500: {{ $primaryHex }} !important;
        --color-blue-600: {{ $theme ? Theme::getHexFromTailwindColor(str_replace('500', '600', $theme->primary)) : Theme::getHexFromTailwindColor(str_replace('500', '600', $defaults['primary'])) }} !important;
        --color-blue-400: {{ $theme ? Theme::getHexFromTailwindColor(str_replace('500', '400', $theme->primary)) : Theme::getHexFromTailwindColor(str_replace('500', '400', $defaults['primary'])) }} !important;
    }

    @layer theme {
        --color-primary: {{ $primaryHex }} !important;

        .dark {
            --color-accent: {{ $primaryHex }} !important;
            --color-accent-content: {{ $theme ? Theme::getHexFromTailwindColor(str_replace('500', '400', $theme->primary)) : Theme::getHexFromTailwindColor(str_replace('500', '400', $defaults['primary'])) }} !important;
            --color-accent-foreground: var(--color-white) !important;

            /* Override Tailwind color variables directly */
            --color-blue-500: {{ $primaryHex }} !important;
            --color-blue-400: {{ $theme ? Theme::getHexFromTailwindColor(str_replace('500', '400', $theme->primary)) : Theme::getHexFromTailwindColor(str_replace('500', '400', $defaults['primary'])) }} !important;
        }
    }

    body {
        font-family: var(--font);
    }

    .bg-primary {
        background-color: var(--primary) !important;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    .border-primary {
        border-color: var(--primary) !important;
    }


    /* Apply custom background and text colors if they are set */
    @if($theme && $theme->background_color)
    body {
        background-color: var(--background-color);
    }
    @endif

    /* Text color is not overridden, using default */

    @if($theme && $theme->button_color)
    .btn-custom {
        background-color: var(--button-color);
        border-color: var(--button-color);
        color: white !important;
    }
    @endif

    /* Override indigo text colors with primary color for list views */
    .text-indigo-300, .text-indigo-400, .text-indigo-500, .text-indigo-600 {
        color: var(--primary) !important;
    }

    /* Badge text color should be white */
    .text-indigo-800 {
        color: white !important;
    }

    .dark .text-indigo-400, .dark .text-indigo-500 {
        color: var(--primary) !important;
    }

    /* Dark mode badge text color should be white */
    .dark .text-indigo-300 {
        color: white !important;
    }

    /* Override indigo background colors with primary color */
    .bg-indigo-100, .bg-indigo-600, .bg-indigo-900\/50 {
        background-color: var(--primary) !important;
    }

    /* Flux-specific styles to ensure they use our custom accent colors */
    [data-flux-control]:focus {
        --tw-ring-color: var(--color-accent) !important;
    }

    .ring-accent {
        --tw-ring-color: var(--color-accent) !important;
    }

    .bg-accent {
        background-color: var(--color-accent) !important;
    }

    .text-accent {
        color: var(--color-accent) !important;
    }

    .border-accent {
        border-color: var(--color-accent) !important;
    }

    /* Flux buttons and interactive elements */
    [data-flux-button] {
        background-color: var(--button-color) !important;
        border-color: var(--button-color) !important;
        color: white !important;
    }

    [data-flux-button]:hover {
        background-color: var(--button-color) !important;
        border-color: var(--button-color) !important;
        color: white !important;
    }

    /* Flux tabs, pills, and other navigation elements */
    [data-flux-tab][aria-selected="true"],
    [data-flux-pill][aria-selected="true"] {
        background-color: var(--button-color) !important;
        color: white !important;
    }

    /* Dark mode styles */
    .dark [data-flux-control]:focus {
        --tw-ring-color: var(--color-accent) !important;
    }

    .dark .ring-accent {
        --tw-ring-color: var(--color-accent) !important;
    }

    .dark .bg-accent {
        background-color: var(--color-accent) !important;
    }

    .dark .text-accent {
        color: var(--color-accent) !important;
    }

    .dark .border-accent {
        border-color: var(--color-accent) !important;
    }

    .dark [data-flux-button] {
        background-color: var(--button-color) !important;
        border-color: var(--button-color) !important;
        color: white !important;
    }

    .dark [data-flux-button]:hover {
        background-color: var(--button-color) !important;
        border-color: var(--button-color) !important;
        color: white !important;
    }

    .dark [data-flux-tab][aria-selected="true"],
    .dark [data-flux-pill][aria-selected="true"] {
        background-color: var(--button-color) !important;
        color: white !important;
    }
</style>
