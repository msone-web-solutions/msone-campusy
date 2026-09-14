@php
    $subjects = \App\Models\Subject::query()->orderBy('sort')->withCount('topicAreas')->with('topicAreas.topics')->get();
    $areaCount = \App\Models\TopicArea::count();
    $topicCount = \App\Models\Topic::count();
    $questionCount = \App\Models\Question::count();
    $minutes = \App\Models\Topic::sum('estimated_minutes');
    $mathe = $subjects->firstWhere('slug', 'mathematik');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head', ['title' => 'Homeschooling Klasse 7'])
</head>
<body class="rq">
    <x-raque.topbar />
    <x-raque.navbar />

    {{-- Hero --}}
    <section class="rq-section--compact rq-section--panel">
        <div class="rq-container rq-hero">
            <div>
                <span class="rq-eyebrow">Homeschooling · Sekundarschule Sachsen-Anhalt</span>
                <h1>Der komplette Lehrplan der 7. Klasse – Thema für Thema erklärt</h1>
                <p>Campusy ist der Lehrer zu Hause: Jedes Thema wird Schritt für Schritt erklärt, der Hefteintrag steht fertig zum Abschreiben bereit, und ein interaktiver Test am Ende zeigt, ob alles sitzt. Aufgebaut nach dem gültigen Fachlehrplan Sekundarschule Sachsen-Anhalt.</p>
                <div style="display:flex;gap:15px;flex-wrap:wrap">
                    <x-raque.button :href="auth()->check() ? route('learn.index') : route('register')" icon="bx bx-book-open" wire:navigate>Alle Fächer ansehen</x-raque.button>
                    @guest
                        <x-raque.button :href="route('login')" variant="outline" wire:navigate>Login</x-raque.button>
                    @endguest
                </div>
            </div>
            <div class="rq-hero__visual" aria-hidden="true">
                <div style="height:100%;display:grid;grid-template-rows:auto 1fr;padding:25px;gap:20px">
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <span class="rq-tag">Mathematik · Klasse 7</span>
                        <span class="rq-badge rq-badge--green"><i class="bx bx-check"></i>Test bestanden</span>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;align-content:start">
                        @foreach ([['1', 'Erklärung', 'bx bx-book-open'], ['2', 'Hefteintrag', 'bx bx-pencil'], ['3', 'Test', 'bx bx-task']] as [$nr, $label, $icon])
                            <div style="background:var(--surface-panel);border-radius:5px;padding:20px 15px;text-align:center">
                                <div class="rq-feature__icon" style="margin:0 auto 12px;width:46px;height:46px;font-size:22px"><i class="{{ $icon }}"></i></div>
                                <div style="font-size:13px;font-weight:500;color:var(--text-body)">Schritt {{ $nr }}</div>
                                <div style="font-size:15px;font-weight:600">{{ $label }}</div>
                            </div>
                        @endforeach
                        <div style="grid-column:1/-1;background:var(--surface-panel);border-radius:5px;padding:18px 20px">
                            <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-body);margin-bottom:8px"><span>Rationale Zahlen</span><span class="rq-num">4/6 Themen</span></div>
                            <div class="rq-progress rq-progress--on-panel"><span style="width:66%"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Promise strip --}}
    <section class="rq-section" id="so-gehts">
        <div class="rq-container rq-grid rq-grid--4">
            <x-raque.feature-box icon="bx bx-book-open" title="Erklärt wie vom Lehrer" link-label="So geht's" :href="route('learn.index')">Jedes Thema mit Beispielen, Merkregeln und typischen Fehlern – in der Sprache der 7. Klasse.</x-raque.feature-box>
            <x-raque.feature-box icon="bx bx-pencil" title="Fertiger Hefteintrag" link-label="Beispiel ansehen" :href="route('learn.index')">Was ins Heft gehört, steht klar abgesetzt zum Abschreiben bereit – mit Datum und Überschrift.</x-raque.feature-box>
            <x-raque.feature-box icon="bx bx-task" title="Interaktiver Test" link-label="Test starten" :href="route('learn.index')">Am Ende jedes Themas ein Test mit sofortigem Feedback. Bestanden ab 70 %, beliebig wiederholbar.</x-raque.feature-box>
            <x-raque.feature-box icon="bx bx-line-chart" title="Nach Lehrplan" link-label="Lehrplan lesen" href="https://www.bildung-lsa.de/informationsportal/unterricht/sekundarschule/schulformbezogene_informationen/lehrplan.htm">Alle Themen folgen dem Fachlehrplan Sekundarschule Sachsen-Anhalt in der Reihenfolge der Inhaltsbereiche.</x-raque.feature-box>
        </div>
    </section>

    {{-- Subject / area grid --}}
    <section class="rq-section rq-section--panel" id="faecher">
        <div class="rq-container">
            <x-raque.section-title eyebrow="Fächer entdecken" title="Die Themenfelder der 7. Klasse">Im Proof of Concept ist Mathematik vollständig ausgearbeitet – weitere Fächer folgen im selben Aufbau.</x-raque.section-title>
            <div class="rq-grid rq-grid--3">
                @if ($mathe)
                    @foreach ($mathe->topicAreas->take(6) as $area)
                        @php $areaQuestions = \App\Models\Question::whereIn('topic_id', $area->topics->pluck('id'))->count(); @endphp
                        <x-raque.course-card
                            :title="$area->name"
                            :href="auth()->check() ? route('learn.subject', $mathe) : route('login')"
                            :category="$mathe->name"
                            author="Klasse 7 · Sekundarschule"
                            :price="'TF '.$area->sort"
                            :icon="['bx bx-plus-circle', 'bx bx-pie-chart-alt-2', 'bx bx-math', 'bx bx-shape-square', 'bx bx-cube', 'bx bx-bar-chart-alt-2'][$area->sort - 1] ?? 'bx bx-book-open'"
                            :meta="[
                                ['icon' => 'bx bx-book', 'label' => $area->topics->count().' Themen'],
                                ['icon' => 'bx bx-task', 'label' => $areaQuestions.' Aufgaben'],
                                ['icon' => 'bx bx-time', 'label' => round($area->topics->sum('estimated_minutes') / 60, 1).' Std.'],
                            ]">
                            <p style="font-size:14px">{{ $area->description }}</p>
                        </x-raque.course-card>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- Stats band --}}
    <section class="rq-section--primary">
        <div class="rq-container rq-grid rq-grid--4">
            <x-raque.fun-fact :value="$subjects->count()" suffix="" label="Fach im Proof of Concept" />
            <x-raque.fun-fact :value="$areaCount" suffix="" label="Themenfelder nach Lehrplan" />
            <x-raque.fun-fact :value="$topicCount" suffix="" label="Themen mit Erklärung, Hefteintrag und Test" />
            <x-raque.fun-fact :value="$questionCount" suffix="+" label="Aufgaben mit Feedback" />
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="rq-section">
        <div class="rq-container">
            <x-raque.section-title eyebrow="Stimmen" title="Das sagen Schüler und Eltern" />
            <div class="rq-grid rq-grid--3">
                <x-raque.testimonial name="Mia" role="Schülerin, 7. Klasse">„Endlich weiß ich genau, was ins Heft muss. Und der Test zeigt mir sofort, wo ich noch üben muss – ohne dass jemand schimpft.“</x-raque.testimonial>
                <x-raque.testimonial name="Familie Krüger" role="Homeschooling seit 2025">„Wir haben lange nach etwas gesucht, das wirklich dem Lehrplan von Sachsen-Anhalt folgt. Die Themenreihenfolge passt zu dem, was die Schule prüft.“</x-raque.testimonial>
                <x-raque.testimonial name="Jonas" role="Schüler, 7. Klasse">„Minus mal minus gibt plus – ich hab's mit dem Schulden-Beispiel endlich verstanden. Die Erklärungen sind wie vom Lehrer, nur ohne Zeitdruck.“</x-raque.testimonial>
            </div>
        </div>
    </section>

    <x-raque.cta-banner title="Heute mit Mathematik anfangen – der erste Test wartet schon">
        <x-raque.button :href="auth()->check() ? route('learn.subject', 'mathematik') : route('register')" variant="on-primary" wire:navigate>Kostenlos starten</x-raque.button>
    </x-raque.cta-banner>

    <x-raque.footer />

    @fluxScripts
</body>
</html>
