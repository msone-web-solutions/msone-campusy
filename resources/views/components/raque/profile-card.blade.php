@props(['name', 'headline', 'stats' => [], 'badges' => [], 'footer' => 'Profil ansehen', 'footerHref' => '#'])

@php $initials = collect(explode(' ', $name))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode(''); @endphp
<div {{ $attributes->merge(['class' => 'rq-card rq-profile']) }}>
    <div class="rq-profile__cover"><div class="rq-profile__avatar">{{ $initials }}</div></div>
    <div class="rq-profile__head">
        <h4>{{ $name }}</h4>
        <span>{{ $headline }}</span>
    </div>
    @if ($badges)
        <ul class="rq-profile__badges">
            @foreach ($badges as $badge)
                <li class="{{ ! empty($badge['earned']) ? 'is-earned' : '' }}" title="{{ $badge['label'] }}"><i class="{{ $badge['icon'] }}"></i></li>
            @endforeach
        </ul>
    @endif
    @if ($stats)
        <ul class="rq-profile__stats">
            @foreach ($stats as $stat)
                <li><span>{{ $stat['label'] }}</span><span>{{ $stat['value'] }}</span></li>
            @endforeach
        </ul>
    @endif
    <a href="{{ $footerHref }}" class="rq-card__footer-link" wire:navigate>{{ $footer }}</a>
</div>
