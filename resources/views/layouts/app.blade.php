<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="rq min-h-screen">
        <x-raque.topbar />
        <x-raque.navbar />

        <main>
            {{ $slot }}
        </main>

        <x-raque.footer />

        {{-- Gentle break reminder after 25 minutes of continuous learning (short, focused blocks beat marathons). --}}
        <div x-data="learnTimer()" x-init="init()" x-show="show" x-cloak class="rq-timer" role="status">
            <i class="bx bx-coffee"></i>
            <p><strong>Du lernst seit 25 Minuten.</strong> Gute Zeit für eine kurze Pause – fünf Minuten weg vom Bildschirm, dann geht's frischer weiter.</p>
            <button type="button" x-on:click="dismiss()">Okay</button>
        </div>
        <script>
            function learnTimer() {
                return {
                    show: false,
                    init() {
                        const key = 'campusy_session_start';
                        const limit = 25 * 60 * 1000;
                        let start = null;
                        try { start = Number(sessionStorage.getItem(key)) || null; } catch (e) {}
                        if (!start || Date.now() - start > 3 * 60 * 60 * 1000) {
                            start = Date.now();
                            try { sessionStorage.setItem(key, String(start)); sessionStorage.removeItem(key + '_ack'); } catch (e) {}
                        }
                        const tick = () => {
                            let ack = false;
                            try { ack = sessionStorage.getItem(key + '_ack') === '1'; } catch (e) {}
                            this.show = !ack && Date.now() - start >= limit;
                        };
                        tick();
                        setInterval(tick, 30000);
                    },
                    dismiss() {
                        this.show = false;
                        try {
                            sessionStorage.setItem('campusy_session_start', String(Date.now()));
                            sessionStorage.setItem('campusy_session_start_ack', '1');
                        } catch (e) {}
                    },
                };
            }
        </script>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
