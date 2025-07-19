@props(['class' => 'h-8 w-auto'])

@php
    $organization = auth()->user()->organization;
    $theme = $organization->themes()->latest()->first();
    $logoPath = $theme?->logo_path;
    $fallbackLogo = $organization->logo; // Use organization's default logo as fallback
@endphp

@if($logoPath)
    <img src="{{ Storage::disk('s3')->url($logoPath) }}" alt="{{ $organization->name }}" class="{{ $class }}">
@elseif($fallbackLogo)
    <img src="{{ $fallbackLogo }}" alt="{{ $organization->name }}" class="{{ $class }}">
@else
    <x-app-logo :class="$class" />
@endif
