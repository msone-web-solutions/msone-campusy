{{-- MemberRow / JobRow: avatar-ish glyph, title, subline, trailing action --}}
@props(['title', 'sub' => null, 'icon' => 'bx bx-book', 'href' => null, 'square' => false, 'nr' => null])

<div {{ $attributes->merge(['class' => 'rq-row']) }}>
    <div class="rq-row__lead">
        <span class="rq-row__avatar {{ $square ? 'rq-row__avatar--square' : '' }}">@if ($nr !== null)<span style="font-size:14px;font-weight:500">{{ $nr }}</span>@else<i class="{{ $icon }}"></i>@endif</span>
        <div class="rq-row__text">
            @if ($href)<a href="{{ $href }}" class="rq-row__title" wire:navigate>{{ $title }}</a>@else<span class="rq-row__title">{{ $title }}</span>@endif
            @if ($sub)<div class="rq-row__sub">{{ $sub }}</div>@endif
        </div>
    </div>
    @if (trim($slot))<div class="rq-row__action">{{ $slot }}</div>@endif
</div>
