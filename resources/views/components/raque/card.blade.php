{{-- Card with optional CardHeader (title + action) and CardFooterLink --}}
@props(['title' => null, 'action' => null, 'footer' => null, 'footerHref' => null, 'pad' => false])

<div {{ $attributes->merge(['class' => 'rq-card']) }}>
    @if ($title)
        <div class="rq-card__header">
            <h4>{{ $title }}</h4>
            @if ($action){{ $action }}@endif
        </div>
    @endif
    @if ($pad)<div class="rq-card__body">{{ $slot }}</div>@else{{ $slot }}@endif
    @if ($footer && $footerHref)
        <a href="{{ $footerHref }}" class="rq-card__footer-link" wire:navigate>{{ $footer }}</a>
    @endif
</div>
