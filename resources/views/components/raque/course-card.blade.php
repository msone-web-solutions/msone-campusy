@props([
    'title',
    'href' => '#',
    'category' => null,
    'author' => null,
    'price' => null,
    'icon' => 'bx bx-book-open',
    'meta' => [],
])

<div {{ $attributes->merge(['class' => 'rq-card rq-card--lift rq-course']) }}>
    <a href="{{ $href }}" class="rq-course__media" aria-hidden="true" tabindex="-1"><i class="{{ $icon }}"></i></a>
    <div class="rq-course__body">
        @if ($category)<div style="margin-bottom:10px"><a href="{{ $href }}" class="rq-tag">{{ $category }}</a></div>@endif
        @if ($author || $price)
            <div class="rq-course__author">
                @if ($author)<span class="rq-user__avatar"><i class="bx bx-user"></i></span><span>{{ $author }}</span>@endif
                @if ($price)<span class="rq-course__price">{{ $price }}</span>@endif
            </div>
        @endif
        <h3><a href="{{ $href }}">{{ $title }}</a></h3>
        {{ $slot }}
    </div>
    @if ($meta)
        <ul class="rq-course__meta">
            @foreach ($meta as $m)
                <li>@if (! empty($m['icon']))<i class="{{ $m['icon'] }}"></i>@endif{{ $m['label'] }}</li>
            @endforeach
        </ul>
    @endif
</div>
