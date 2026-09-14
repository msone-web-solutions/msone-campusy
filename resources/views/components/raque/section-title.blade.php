{{-- SectionTitle: tracked eyebrow with teal dots, 38/300 headline with a bold run, 50×2 teal rule. Every heading ends in a full stop. --}}
@props(['eyebrow' => null, 'title', 'emphasis' => null, 'align' => 'center', 'tone' => 'ink'])

@php
    $html = e($title);
    if ($emphasis !== null && str_contains($title, $emphasis)) {
        $html = str_replace(e($emphasis), '<strong>'.e($emphasis).'</strong>', $html);
    }
@endphp
<div {{ $attributes->merge(['class' => 'rq-section-title'.($align === 'center' ? ' rq-section-title--center' : '').($tone === 'light' ? ' rq-section-title--light' : '')]) }}>
    @if ($eyebrow)<span class="rq-eyebrow rq-eyebrow--tracked">{{ $eyebrow }}</span>@endif
    <h2>{!! $html !!}</h2>
    @if (trim($slot) !== '')<p>{{ $slot }}</p>@endif
</div>
