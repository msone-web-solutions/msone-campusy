@props(['title', 'eyebrow' => null, 'crumbs' => [], 'compact' => false, 'tabs' => []])

<div {{ $attributes->merge(['class' => 'rq-page-banner'.($compact ? ' rq-page-banner--compact' : '')]) }}>
    <div class="rq-container">
        @if ($crumbs)
            <ul class="rq-crumbs">
                @foreach ($crumbs as $crumb)
                    <li>
                        @if (! empty($crumb['href']))<a href="{{ $crumb['href'] }}" wire:navigate>{{ $crumb['label'] }}</a>@else{{ $crumb['label'] }}@endif
                    </li>
                @endforeach
            </ul>
        @endif
        @if ($eyebrow)<span class="rq-page-banner__eyebrow">{{ $eyebrow }}</span>@endif
        <h1>{{ $title }}</h1>
        {{ $slot }}
        @if ($tabs)
            <ul class="rq-page-banner__tabs">
                @foreach ($tabs as $tab)
                    <li><a href="{{ $tab['href'] }}" class="{{ ! empty($tab['active']) ? 'is-active' : '' }}" wire:navigate>{{ $tab['label'] }}</a></li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
