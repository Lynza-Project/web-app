@php
    use App\Models\Theme;

    $organization = auth()->check() ? auth()->user()->organization : null;
    $theme = $organization ? $organization->themes()->latest()->first() : null;

    // Default theme values as fallback
    $defaults = [
        'primary' => 'blue-500',
        'danger' => 'red-500',
        'gray' => 'gray-500',
        'info' => 'blue-500',
        'success' => 'emerald-500',
        'warning' => 'amber-500',
        'font' => 'Inter',
        'background_color' => 'white',
        'text_color' => 'zinc-900',
        'button_color' => 'blue-500',
    ];

    // Convert Tailwind color names to hex values
    $primaryHex = $theme ? Theme::getHexFromTailwindColor($theme->primary) : Theme::getHexFromTailwindColor($defaults['primary']);
    $dangerHex = $theme ? Theme::getHexFromTailwindColor($theme->danger) : Theme::getHexFromTailwindColor($defaults['danger']);
    $grayHex = $theme ? Theme::getHexFromTailwindColor($theme->gray) : Theme::getHexFromTailwindColor($defaults['gray']);
    $infoHex = $theme ? Theme::getHexFromTailwindColor($theme->info) : Theme::getHexFromTailwindColor($defaults['info']);
    $successHex = $theme ? Theme::getHexFromTailwindColor($theme->success) : Theme::getHexFromTailwindColor($defaults['success']);
    $warningHex = $theme ? Theme::getHexFromTailwindColor($theme->warning) : Theme::getHexFromTailwindColor($defaults['warning']);
    $backgroundHex = $theme && $theme->background_color ? Theme::getHexFromTailwindColor($theme->background_color) : '#ffffff';
    $textHex = $theme && $theme->text_color ? Theme::getHexFromTailwindColor($theme->text_color) : '#18181b';
    $buttonHex = $theme && $theme->button_color ? Theme::getHexFromTailwindColor($theme->button_color) : $primaryHex;
@endphp

<style>
    :root {
        --primary: {{ $primaryHex }};
        --danger: {{ $dangerHex }};
        --gray: {{ $grayHex }};
        --info: {{ $infoHex }};
        --success: {{ $successHex }};
        --warning: {{ $warningHex }};
        --font: "{{ $theme->font ?? $defaults['font'] }}", sans-serif;
        --background-color: {{ $backgroundHex }};
        --text-color: {{ $textHex }};
        --button-color: {{ $buttonHex }};

        /* Override accent colors with theme primary color */
        --color-accent: {{ $primaryHex }};
        --color-accent-content: {{ $primaryHex }};
        --color-accent-foreground: #ffffff;
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

    .bg-danger {
        background-color: var(--danger) !important;
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .border-danger {
        border-color: var(--danger) !important;
    }

    .bg-success {
        background-color: var(--success) !important;
    }

    .text-success {
        color: var(--success) !important;
    }

    .border-success {
        border-color: var(--success) !important;
    }

    .bg-warning {
        background-color: var(--warning) !important;
    }

    .text-warning {
        color: var(--warning) !important;
    }

    .border-warning {
        border-color: var(--warning) !important;
    }

    .bg-info {
        background-color: var(--info) !important;
    }

    .text-info {
        color: var(--info) !important;
    }

    .border-info {
        border-color: var(--info) !important;
    }

    .bg-gray {
        background-color: var(--gray) !important;
    }

    .text-gray {
        color: var(--gray) !important;
    }

    .border-gray {
        border-color: var(--gray) !important;
    }

    /* Apply custom background and text colors if they are set */
    @if($theme && $theme->background_color)
    body {
        background-color: var(--background-color);
    }
    @endif

    @if($theme && $theme->text_color)
    body {
        color: var(--text-color);
    }
    @endif

    @if($theme && $theme->button_color)
    .btn-custom {
        background-color: var(--button-color);
        border-color: var(--button-color);
    }
    @endif
</style>
