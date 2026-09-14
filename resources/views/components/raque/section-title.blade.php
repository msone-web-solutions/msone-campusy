@props(['eyebrow' => null, 'title', 'align' => 'center'])

<div {{ $attributes->merge(['class' => 'rq-section-title'.($align === 'left' ? ' rq-section-title--left' : '')]) }}>
    @if ($eyebrow)<span class="rq-eyebrow">{{ $eyebrow }}</span>@endif
    <h2>{{ $title }}</h2>
    @if (trim($slot) !== '')<p>{{ $slot }}</p>@endif
</div>
