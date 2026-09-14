@props(['title', 'eyebrow' => null, 'crumbs' => [], 'compact' => false])

<div {{ $attributes->merge(['class' => 'rq-page-banner'.($compact ? ' rq-page-banner--compact' : '')]) }}>
    <div class="rq-container">
        @if ($eyebrow)<span class="rq-page-banner__eyebrow">{{ $eyebrow }}</span>@endif
        <h1>{{ $title }}</h1>
        @if ($crumbs)
            <ul class="rq-crumbs">
                @foreach ($crumbs as $crumb)
                    <li>
                        @if (! empty($crumb['href']))<a href="{{ $crumb['href'] }}" wire:navigate>{{ $crumb['label'] }}</a>@else{{ $crumb['label'] }}@endif
                    </li>
                @endforeach
            </ul>
        @endif
        {{ $slot }}
    </div>
</div>
