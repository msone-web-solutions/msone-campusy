<div class="rq-topbar">
    <div class="rq-container rq-topbar__inner">
        <span class="rq-topbar__item"><i class="bx bx-book-open"></i>Klasse 7 · Sekundarschule Sachsen-Anhalt · <strong>Lehrplan 2019</strong></span>
        <span class="rq-topbar__links">
            @auth
                <span style="color:#fff">{{ auth()->user()->name }}</span>
                <a href="{{ route('profile.edit') }}" wire:navigate>Einstellungen</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf<button type="submit" style="background:none;border:0;padding:0;font:inherit;color:inherit;cursor:pointer">Abmelden</button></form>
            @else
                <a href="{{ route('login') }}" wire:navigate>Login</a>
                <a href="{{ route('register') }}" wire:navigate>Registrieren</a>
            @endauth
        </span>
    </div>
</div>
