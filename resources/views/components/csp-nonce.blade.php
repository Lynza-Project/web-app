@php use App\Http\Middleware\SecurityHeaders; @endphp
@props(['tag' => 'script'])

@php
    $nonce = SecurityHeaders::getNonce();
@endphp

@if($tag === 'script')
    <script nonce="{{ $nonce }}" {{ $attributes }}>
        {{ $slot }}
    </script>
@elseif($tag === 'style')
    <style nonce="{{ $nonce }}" {{ $attributes }}>
        {{ $slot }}
    </style>
@endif
