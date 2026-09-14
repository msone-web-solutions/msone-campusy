<nav class="rq-navbar">
    <div class="rq-container rq-navbar__inner">
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="rq-navbar__brand" wire:navigate><i class="bx bxs-graduation"></i>Campusy</a>
        <ul class="rq-navbar__nav">
            @auth
                <li><a href="{{ route('dashboard') }}" class="rq-navbar__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" wire:navigate>Dashboard</a></li>
                <li><a href="{{ route('learn.index') }}" class="rq-navbar__link {{ request()->routeIs('learn.*') ? 'is-active' : '' }}" wire:navigate>Fächer</a></li>
                <li><a href="{{ route('learn.subject', 'mathematik') }}" class="rq-navbar__link {{ request()->is('lernen/mathematik*') ? 'is-active' : '' }}" wire:navigate>Mathematik</a></li>
                <li><a href="{{ route('profile.edit') }}" class="rq-navbar__link {{ request()->routeIs('profile.*', 'appearance.*', 'security.*') ? 'is-active' : '' }}" wire:navigate>Einstellungen</a></li>
            @else
                <li><a href="{{ route('home') }}" class="rq-navbar__link {{ request()->routeIs('home') ? 'is-active' : '' }}" wire:navigate>Start</a></li>
                <li><a href="{{ route('home') }}#faecher" class="rq-navbar__link">Fächer</a></li>
                <li><a href="{{ route('home') }}#so-gehts" class="rq-navbar__link">So geht's</a></li>
                <li><a href="{{ route('login') }}" class="rq-navbar__link {{ request()->routeIs('login') ? 'is-active' : '' }}" wire:navigate>Login</a></li>
            @endauth
        </ul>
        <div class="rq-navbar__actions">
            @auth
                <x-raque.button :href="route('learn.index')" size="sm" icon="bx bx-book-open" wire:navigate>Lernen</x-raque.button>
            @else
                <x-raque.button :href="route('register')" size="sm" wire:navigate>Registrieren</x-raque.button>
            @endauth
        </div>
    </div>
</nav>
