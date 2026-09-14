<footer class="rq-footer">
    <div class="rq-container">
        <div class="rq-footer__grid">
            <div>
                <h3>Campusy</h3>
                <ul>
                    <li><a href="{{ route('home') }}" wire:navigate>Homeschooling Klasse 7</a></li>
                    <li><a href="mailto:kontakt@msone.cloud">kontakt@msone.cloud</a></li>
                    <li><span>Sachsen-Anhalt · Lehrplan 2019</span></li>
                </ul>
            </div>
            <div>
                @if (auth()->check() && auth()->user()->isParent())
                    <h3>Eltern</h3>
                    <ul>
                        <li><a href="{{ route('parent.dashboard') }}" wire:navigate>Wochenbericht</a></li>
                        <li><a href="{{ route('family.edit') }}" wire:navigate>Kinder verknüpfen</a></li>
                    </ul>
                @else
                    <h3>Lernen</h3>
                    <ul>
                        <li><a href="{{ route('learn.index') }}" wire:navigate>Alle Fächer</a></li>
                        <li><a href="{{ route('school-day') }}" wire:navigate>Stundenplan</a></li>
                        <li><a href="{{ route('practice') }}" wire:navigate>Tägliche Übung</a></li>
                        <li><a href="{{ route('dashboard') }}" wire:navigate>Mein Fortschritt</a></li>
                    </ul>
                @endif
            </div>
            <div>
                <h3>Lehrplan</h3>
                <ul>
                    <li><a href="https://www.bildung-lsa.de/informationsportal/unterricht/sekundarschule/schulformbezogene_informationen/lehrplan.htm" target="_blank" rel="noopener">Fachlehrpläne Sekundarschule</a></li>
                    <li><a href="https://lisa.sachsen-anhalt.de/" target="_blank" rel="noopener">LISA Sachsen-Anhalt</a></li>
                    <li><a href="https://www.kmk.org/themen/qualitaetssicherung-in-schulen/bildungsstandards.html" target="_blank" rel="noopener">KMK-Bildungsstandards</a></li>
                </ul>
            </div>
            <div>
                <h3>Konto</h3>
                <ul>
                    @auth
                        <li><a href="{{ route('profile.edit') }}" wire:navigate>Profil</a></li>
                        <li><a href="{{ route('security.edit') }}" wire:navigate>Sicherheit</a></li>
                    @else
                        <li><a href="{{ route('login') }}" wire:navigate>Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
        <div class="rq-footer__base">
            <div class="rq-footer__base-inner">
                <span class="rq-footer__brand"><i class="bx bxs-graduation"></i>Campusy</span>
                <p>© {{ now()->year }} Campusy · Lehrplaninhalte: Landesportal Sachsen-Anhalt, CC BY-SA 3.0</p>
            </div>
        </div>
    </div>
</footer>
