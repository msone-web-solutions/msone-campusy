<nav class="rq-navbar">
    <div class="rq-container rq-navbar__inner">
        @php $isParent = auth()->check() && auth()->user()->isParent(); @endphp
        <a href="{{ auth()->check() ? ($isParent ? route('parent.dashboard') : route('dashboard')) : route('home') }}" class="rq-navbar__brand" wire:navigate><i class="bx bxs-graduation"></i>Campusy</a>
        <ul class="rq-navbar__nav">
            @auth
                @if ($isParent)
                    <li><a href="{{ route('parent.dashboard') }}" class="rq-navbar__link {{ request()->routeIs('parent.*') ? 'is-active' : '' }}" wire:navigate>Wochenbericht</a></li>
                    <li><a href="{{ route('family.edit') }}" class="rq-navbar__link {{ request()->routeIs('family.*') ? 'is-active' : '' }}" wire:navigate>Familie</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="rq-navbar__link {{ request()->routeIs('profile.*', 'security.*') ? 'is-active' : '' }}" wire:navigate>Einstellungen</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}" class="rq-navbar__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" wire:navigate>Dashboard</a></li>
                    <li><a href="{{ route('school-day') }}" class="rq-navbar__link {{ request()->routeIs('school-day') ? 'is-active' : '' }}" wire:navigate>Schultag</a></li>
                    <li><a href="{{ route('learn.index') }}" class="rq-navbar__link {{ request()->routeIs('learn.*') ? 'is-active' : '' }}" wire:navigate>Fächer</a></li>
                    @php $due = app(\App\Review\ReviewPlanner::class)->dueCountFor(auth()->user()); @endphp
                    <li><a href="{{ route('practice') }}" class="rq-navbar__link {{ request()->routeIs('practice') ? 'is-active' : '' }}" wire:navigate>Üben @if ($due > 0)<span class="rq-navbar__count">{{ $due }}</span>@endif</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="rq-navbar__link {{ request()->routeIs('profile.*', 'appearance.*', 'security.*', 'family.*') ? 'is-active' : '' }}" wire:navigate>Einstellungen</a></li>
                @endif
            @else
                <li><a href="{{ route('home') }}" class="rq-navbar__link {{ request()->routeIs('home') ? 'is-active' : '' }}" wire:navigate>Start</a></li>
                <li><a href="{{ route('home') }}#faecher" class="rq-navbar__link">Fächer</a></li>
                <li><a href="{{ route('home') }}#so-gehts" class="rq-navbar__link">So geht's</a></li>
                <li><a href="{{ route('login') }}" class="rq-navbar__link {{ request()->routeIs('login') ? 'is-active' : '' }}" wire:navigate>Login</a></li>
            @endauth
        </ul>
        <div class="rq-navbar__actions">
            @auth
                @if ($isParent)
                    <x-raque.button :href="route('parent.dashboard')" size="sm" icon="bx bx-group" wire:navigate>Elternübersicht</x-raque.button>
                @else
                    <x-raque.button :href="route('learn.index')" size="sm" icon="bx bx-book-open" wire:navigate>Lernen</x-raque.button>
                @endif
            @else
                <x-raque.button :href="route('register')" size="sm" wire:navigate>Registrieren</x-raque.button>
            @endauth
        </div>
    </div>
</nav>
