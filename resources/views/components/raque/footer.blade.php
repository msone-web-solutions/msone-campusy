{{-- SiteFooter: no link columns – centred brand, one mission sentence, links row, copyright + legal --}}
<footer class="rq-footer">
    <div class="rq-container">
        <span class="rq-footer__brand"><i class="bx bxs-graduation"></i>Campusy</span>
        <p class="rq-footer__blurb">Wir bringen den kompletten Lehrplan der 7. Klasse nach Hause: erklärt wie vom Lehrer, mit fertigem Hefteintrag und einem Test, der zeigt, ob alles sitzt.</p>
        <ul class="rq-footer__links">
            @if (auth()->check() && auth()->user()->isParent())
                <li><a href="{{ route('parent.dashboard') }}" wire:navigate>Wochenbericht</a></li>
                <li><a href="{{ route('family.edit') }}" wire:navigate>Familie</a></li>
            @elseif (auth()->check())
                <li><a href="{{ route('learn.index') }}" wire:navigate>Fächer</a></li>
                <li><a href="{{ route('school-day') }}" wire:navigate>Stundenplan</a></li>
                <li><a href="{{ route('week-plan') }}" wire:navigate>Wochenplan</a></li>
                <li><a href="{{ route('practice') }}" wire:navigate>Tägliche Übung</a></li>
            @else
                <li><a href="{{ route('home') }}#faecher" wire:navigate>Fächer</a></li>
                <li><a href="{{ route('login') }}" wire:navigate>Login</a></li>
            @endif
            <li><a href="https://www.bildung-lsa.de/informationsportal/unterricht/sekundarschule/schulformbezogene_informationen/lehrplan.htm" target="_blank" rel="noopener">Lehrplan Sachsen-Anhalt</a></li>
        </ul>
        <div class="rq-footer__base">
            <div class="rq-footer__base-inner">
                <p>© {{ now()->year }} Campusy · Lehrplaninhalte: Landesportal Sachsen-Anhalt, CC BY-SA 3.0</p>
                <ul class="rq-footer__legal">
                    <li><a href="mailto:kontakt@msone.cloud">Kontakt</a></li>
                    @auth<li><a href="{{ route('profile.edit') }}" wire:navigate>Profil</a></li><li><a href="{{ route('security.edit') }}" wire:navigate>Sicherheit</a></li>@endauth
                </ul>
            </div>
        </div>
    </div>
</footer>
