@php
    use App\Models\Theme;

    $organization = auth()->check() ? auth()->user()->organization : null;
    $theme = $organization ? $organization->themes()->latest()->first() : null;

    $defaults = [
        'primary' => 'blue-500',
        'font' => 'Inter',
        'background_color' => 'white',
        'button_color' => 'blue-500',
    ];

    $primaryHex = $theme ? Theme::getHexFromTailwindColor($theme->primary) : Theme::getHexFromTailwindColor($defaults['primary']);
    $backgroundHex = $theme && $theme->background_color ?
        ($theme->background_color === 'white' ? '#ffffff' : Theme::getHexFromTailwindColor($theme->background_color))
        : '#ffffff';
    $buttonHex = $theme && $theme->button_color ? Theme::getHexFromTailwindColor($theme->button_color) : $primaryHex;

    $primaryContent600 = $theme ?
        Theme::getHexFromTailwindColor(str_replace('500', '600', $theme->primary)) :
        Theme::getHexFromTailwindColor(str_replace('500', '600', $defaults['primary']));

    $primaryContent400 = $theme ?
        Theme::getHexFromTailwindColor(str_replace('500', '400', $theme->primary)) :
        Theme::getHexFromTailwindColor(str_replace('500', '400', $defaults['primary']));
@endphp

<style>
    :root {
        --primary: {{ $primaryHex }};
        --font: "{{ $theme->font ?? $defaults['font'] }}", sans-serif;
        --background-color: {{ $backgroundHex }};
        --button-color: {{ $buttonHex }};
        --color-white: #ffffff;

        --color-accent: {{ $primaryHex }} !important;
        --color-accent-content: {{ $primaryContent600 }} !important;
        --color-accent-foreground: var(--color-white) !important;

        --color-blue-500: {{ $primaryHex }} !important;
        --color-blue-600: {{ $primaryContent600 }} !important;
        --color-blue-400: {{ $primaryContent400 }} !important;
    }

    @layer theme {
        --color-primary: {{ $primaryHex }} !important;

        .dark {
            --color-accent: {{ $primaryHex }} !important;
            --color-accent-content: {{ $primaryContent400 }} !important;
            --color-accent-foreground: var(--color-white) !important;

            --color-blue-500: {{ $primaryHex }} !important;
            --color-blue-400: {{ $primaryContent400 }} !important;
        }
    }

    body {
        font-family: var(--font);
    }

    .bg-primary { background-color: var(--primary) !important; }
    .text-primary { color: var(--primary) !important; }
    .border-primary { border-color: var(--primary) !important; }

    @if($theme && $theme->background_color)
    body { background-color: var(--background-color); }
    @endif

    @if($theme && $theme->button_color)
    .btn-custom {
        background-color: var(--button-color);
        border-color: var(--button-color);
        color: white !important;
    }
    @endif

    .text-indigo-300, .text-indigo-400, .text-indigo-500, .text-indigo-600 {
        color: var(--primary) !important;
    }

    .text-indigo-800 { color: white !important; }
    .dark .text-indigo-400, .dark .text-indigo-500 { color: var(--primary) !important; }
    .dark .text-indigo-300 { color: white !important; }

    .bg-indigo-100, .bg-indigo-600, .bg-indigo-900\/50 {
        background-color: var(--primary) !important;
    }

    [data-flux-control]:focus, .dark [data-flux-control]:focus {
        --tw-ring-color: var(--color-accent) !important;
    }

    .ring-accent, .dark .ring-accent {
        --tw-ring-color: var(--color-accent) !important;
    }

    .bg-accent, .dark .bg-accent {
        background-color: var(--color-accent) !important;
    }

    .text-accent, .dark .text-accent {
        color: var(--color-accent) !important;
    }

    .border-accent, .dark .border-accent {
        border-color: var(--color-accent) !important;
    }

    [data-flux-button], .dark [data-flux-button] {
        background-color: var(--button-color) !important;
        border-color: var(--button-color) !important;
        color: white !important;
    }

    [data-flux-button]:hover, .dark [data-flux-button]:hover {
        background-color: var(--button-color) !important;
        border-color: var(--button-color) !important;
        color: white !important;
    }


    [data-flux-button]:hover, .dark [data-flux-button]:hover {
        background-color: var(--button-color) !important;
        border-color: var(--button-color) !important;
        color: white !important;
    }

    [data-flux-modal-close] button,
    [data-flux-modal-close] [data-flux-button],
    [data-flux-modal-close] button:hover,
    [data-flux-modal-close] [data-flux-button]:hover,
    [data-flux-modal-close] button:focus,
    [data-flux-modal-close] [data-flux-button]:focus,
    [data-flux-modal-close] button:active,
    [data-flux-modal-close] [data-flux-button]:active,
    .dark [data-flux-modal-close] button,
    .dark [data-flux-modal-close] [data-flux-button],
    .dark [data-flux-modal-close] button:hover,
    .dark [data-flux-modal-close] [data-flux-button]:hover,
    .dark [data-flux-modal-close] button:focus,
    .dark [data-flux-modal-close] [data-flux-button]:focus,
    .dark [data-flux-modal-close] button:active,
    .dark [data-flux-modal-close] [data-flux-button]:active {
        color: white !important;
        cursor: pointer;
    }

    [data-flux-modal-close] svg,
    [data-flux-modal-close] button svg,
    [data-flux-modal-close] [data-flux-button] svg,
    .dark [data-flux-modal-close] svg,
    .dark [data-flux-modal-close] button svg,
    .dark [data-flux-modal-close] [data-flux-button] svg {
        color: white !important;
    }

    /* Override any dynamically applied classes */
    [data-flux-modal-close] button[class*="text-"],
    [data-flux-modal-close] [data-flux-button][class*="text-"],
    .dark [data-flux-modal-close] button[class*="text-"],
    .dark [data-flux-modal-close] [data-flux-button][class*="text-"] {
        color: white !important;
    }

</style>
