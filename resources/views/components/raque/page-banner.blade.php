{{-- PageTop: coloured band the transparent header overlays; 70px/100 title with a bold run --}}
@props(['title', 'emphasis' => null, 'eyebrow' => null, 'crumbs' => [], 'compact' => false, 'tabs' => []])

@php
    $html = e($title);
    if ($emphasis !== null && str_contains($title, $emphasis)) {
        $html = str_replace(e($emphasis), '<strong>'.e($emphasis).'</strong>', $html);
    } elseif ($emphasis === true) {
        // The last word carries the weight, as the source does ("Popular Courses.").
        $words = preg_split('/\s+/', trim($title)) ?: [];
        $last = array_pop($words);
        $html = ($words ? e(implode(' ', $words)).' ' : '').'<strong>'.e((string) $last).'</strong>';
    }
@endphp
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
        <h1>{!! $html !!}</h1>
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
