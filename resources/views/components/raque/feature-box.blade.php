@props(['icon', 'title', 'linkLabel' => null, 'href' => '#'])

<div {{ $attributes->merge(['class' => 'rq-card rq-card--lift rq-feature']) }}>
    <div class="rq-feature__icon"><i class="{{ $icon }}"></i></div>
    <h3><a href="{{ $href }}">{{ $title }}</a></h3>
    <p>{{ $slot }}</p>
    @if ($linkLabel)<a href="{{ $href }}" class="rq-feature__link">{{ $linkLabel }} +</a>@endif
</div>
