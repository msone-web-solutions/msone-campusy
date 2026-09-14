@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'href' => null,
    'type' => 'button',
])

@php
    $classes = collect(['rq-btn'])
        ->when($variant !== 'primary', fn ($c) => $c->push('rq-btn--'.$variant))
        ->when($size === 'sm', fn ($c) => $c->push('rq-btn--sm'))
        ->when($icon, fn ($c) => $c->push('rq-btn--icon'))
        ->join(' ');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<i class="{{ $icon }}"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<i class="{{ $icon }}"></i>@endif
        {{ $slot }}
    </button>
@endif
