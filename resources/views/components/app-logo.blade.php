@props(['class' => 'w-16 h-16'])

@php
    use Illuminate\Support\Facades\Storage;

    $organization = auth()->check() ? auth()->user()->organization : null;
    $theme = $organization ? $organization->themes()->latest()->first() : null;
    $logoPath = $theme?->logo_path;
@endphp

<div class="items-center justify-center rounded-md">
    @if($logoPath && auth()->check())
        <img src="{{ Storage::disk('s3')->url($logoPath) }}" alt="Logo" class="{{ $class }}">
    @else
        <img src="{{ asset('img/lynza_couleurs-svg.svg') }}" alt="Logo" class="{{ $class }}">
    @endif
</div>
<div class="ml-1 grid flex-1 text-left text-sm">
    <span class="mb-0.5 truncate leading-none font-semibold">Lynza</span>
</div>
