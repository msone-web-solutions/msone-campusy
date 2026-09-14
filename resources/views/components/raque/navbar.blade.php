@php
    $isParent = auth()->check() && auth()->user()->isParent();
    $due = auth()->check() && ! $isParent ? app(\App\Review\ReviewPlanner::class)->dueCountFor(auth()->user()) : 0;
    $initials = auth()->check() ? collect(explode(' ', auth()->user()->name))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('') : '';
@endphp
<header class="rq-navbar">
    <div class="rq-container rq-navbar__inner">
        <a href="{{ auth()->check() ? ($isParent ? route('parent.dashboard') : route('dashboard')) : route('home') }}" class="rq-navbar__brand" wire:navigate><i class="bx bxs-graduation"></i>Campusy</a>

        @auth
            @unless ($isParent)
                <form class="rq-navbar__search" action="{{ route('learn.index') }}" method="get" role="search">
                    <input type="search" name="q" value="{{ request()->routeIs('learn.index') ? request('q') : '' }}" placeholder="Thema suchen" aria-label="Thema suchen">
                    <button type="submit" aria-label="Suchen"><i class="bx bx-search"></i></button>
                </form>
            @endunless
        @endauth

        <ul class="rq-navbar__nav">
            @auth
                @if ($isParent)
                    <li><a href="{{ route('parent.dashboard') }}" class="rq-navbar__link {{ request()->routeIs('parent.*') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-home"></i>Wochenbericht</a></li>
                    <li><a href="{{ route('family.edit') }}" class="rq-navbar__link {{ request()->routeIs('family.*') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-group"></i>Familie</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="rq-navbar__link {{ request()->routeIs('profile.*', 'security.*') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-cog"></i>Einstellungen</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}" class="rq-navbar__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-home"></i>Home</a></li>
                    <li><a href="{{ route('school-day') }}" class="rq-navbar__link {{ request()->routeIs('school-day') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-time-five"></i>Schultag</a></li>
                    <li><a href="{{ route('week-plan') }}" class="rq-navbar__link {{ request()->routeIs('week-plan') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-calendar-week"></i>Woche</a></li>
                    <li><a href="{{ route('learn.index') }}" class="rq-navbar__link {{ request()->routeIs('learn.*') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-book-open"></i>Fächer</a></li>
                    <li><a href="{{ route('practice') }}" class="rq-navbar__link {{ request()->routeIs('practice') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-refresh"></i>Üben @if ($due > 0)<span class="rq-navbar__count">{{ $due }}</span>@endif</a></li>
                @endif
            @else
                <li><a href="{{ route('home') }}" class="rq-navbar__link {{ request()->routeIs('home') ? 'is-active' : '' }}" wire:navigate><i class="bx bx-home"></i>Start</a></li>
                <li><a href="{{ route('home') }}#faecher" class="rq-navbar__link"><i class="bx bx-book-open"></i>Fächer</a></li>
                <li><a href="{{ route('home') }}#so-gehts" class="rq-navbar__link"><i class="bx bx-info-circle"></i>So geht's</a></li>
            @endauth
        </ul>

        <div class="rq-navbar__actions">
            @auth
                @unless ($isParent)
                    <a href="{{ route('practice') }}" class="rq-icon-btn" aria-label="Fällige Übungen" title="Fällige Übungen" wire:navigate><i class="bx bx-bell"></i>@if ($due > 0)<span class="rq-icon-btn__count">{{ $due }}</span>@endif</a>
                @endunless
                <a href="{{ route('profile.edit') }}" class="rq-icon-btn" aria-label="Einstellungen" title="Einstellungen" wire:navigate><i class="bx bx-cog"></i></a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="rq-icon-btn" aria-label="Abmelden" title="Abmelden"><i class="bx bx-log-out"></i></button>
                </form>
                <a href="{{ route('profile.edit') }}" class="rq-navbar__avatar" title="{{ auth()->user()->name }}" wire:navigate>{{ $initials }}</a>
            @else
                <a href="{{ route('login') }}" class="rq-navbar__login" wire:navigate>Log in</a>
            @endauth
        </div>
    </div>
</header>
