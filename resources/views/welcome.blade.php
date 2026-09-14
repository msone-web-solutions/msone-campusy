@php
    $subjects = \App\Models\Subject::query()->orderBy('sort')->withCount('topicAreas')->with('topicAreas.topics')->get();
    $areaCount = \App\Models\TopicArea::count();
    $topicCount = \App\Models\Topic::count();
    $questionCount = \App\Models\Question::count();
    $minutes = \App\Models\Topic::sum('estimated_minutes');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head', ['title' => 'Homeschooling Klasse 7'])
</head>
<body class="rq">
    <x-raque.topbar />
    <x-raque.navbar />

    {{-- Hero: full-bleed illustration ground, header overlays it --}}
    <section class="rq-hero-band">
        <div class="rq-container rq-hero">
            <div>
                <span class="rq-eyebrow rq-eyebrow--tracked" style="margin-left:42px">Homeschooling Klasse 7</span>
                <h1><strong>Der Lehrplan</strong> der 7. Klasse –<br>Thema für <strong>Thema erklärt</strong></h1>
                <p>Campusy ist der Lehrer zu Hause: Jedes Thema wird Schritt für Schritt erklärt, der Hefteintrag steht fertig zum Abschreiben bereit, und ein interaktiver Test am Ende zeigt, ob alles sitzt. Aufgebaut nach dem gültigen Fachlehrplan Sekundarschule Sachsen-Anhalt.</p>
                <div style="display:flex;gap:15px;flex-wrap:wrap">
                    <x-raque.button :href="auth()->check() ? (auth()->user()->isParent() ? route('parent.dashboard') : route('learn.index')) : route('login')" variant="on-primary" wire:navigate>{{ auth()->check() && auth()->user()->isParent() ? 'Zum Wochenbericht' : 'Alle Fächer ansehen' }}</x-raque.button>
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

    {{-- Subject grid --}}
    <section class="rq-section rq-section--panel" id="faecher">
        <div class="rq-container">
            <x-raque.section-title eyebrow="Fächer entdecken" title="Drei Fächer, ein Aufbau." emphasis="ein Aufbau.">Jedes Thema folgt dem gleichen Weg: Erklärung, Hefteintrag, Test – nach dem Lehrplan von Sachsen-Anhalt in der Reihenfolge, wie die Schule sie prüft.</x-raque.section-title>
            <div class="rq-grid rq-grid--3">
                @foreach ($subjects as $subject)
                    @php
                        $subjectTopics = $subject->topicAreas->flatMap->topics;
                        $subjectQuestions = \App\Models\Question::whereIn('topic_id', $subjectTopics->pluck('id'))->count();
                        $subjectIcon = ['mathematik' => 'bx bx-math', 'chemie' => 'bx bx-test-tube', 'informatik' => 'bx bx-code-alt'][$subject->slug] ?? 'bx bx-book-open';
                    @endphp
                    <x-raque.course-card
                        :title="$subject->name"
                        :href="auth()->check() ? route('learn.subject', $subject) : route('login')"
                        category="Klasse 7"
                        author="Sekundarschule Sachsen-Anhalt"
                        :price="$subject->topic_areas_count.' Themenfelder'"
                        :icon="$subjectIcon"
                        :meta="[
                            ['icon' => 'bx bx-book', 'label' => $subjectTopics->count().' Themen'],
                            ['icon' => 'bx bx-task', 'label' => $subjectQuestions.' Aufgaben'],
                            ['icon' => 'bx bx-time', 'label' => round($subjectTopics->sum('estimated_minutes') / 60, 1).' Std.'],
                        ]">
                        <ul style="font-size:14px;margin:0;padding-left:18px;display:grid;gap:4px">
                            @foreach ($subject->topicAreas as $area)
                                <li>{{ $area->name }}</li>
                            @endforeach
                        </ul>
                    </x-raque.course-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Stats band --}}
    <section class="rq-section--primary">
        <div class="rq-container rq-grid rq-grid--4">
            <x-raque.fun-fact :value="$subjects->count()" suffix="" label="Fächer nach Lehrplan" />
            <x-raque.fun-fact :value="$areaCount" suffix="" label="Themenfelder nach Lehrplan" />
            <x-raque.fun-fact :value="$topicCount" suffix="" label="Themen mit Erklärung, Hefteintrag und Test" />
            <x-raque.fun-fact :value="$questionCount" suffix="+" label="Aufgaben mit Feedback" />
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="rq-section">
        <div class="rq-container">
            <x-raque.section-title eyebrow="Was sie sagen" title="Das sagen Schüler und Eltern." emphasis="Schüler und Eltern." />
            <div class="rq-grid rq-grid--3">
                <x-raque.testimonial name="Mia" role="Schülerin, 7. Klasse">„Endlich weiß ich genau, was ins Heft muss. Und der Test zeigt mir sofort, wo ich noch üben muss – ohne dass jemand schimpft.“</x-raque.testimonial>
                <x-raque.testimonial name="Familie Krüger" role="Homeschooling seit 2025">„Wir haben lange nach etwas gesucht, das wirklich dem Lehrplan von Sachsen-Anhalt folgt. Die Themenreihenfolge passt zu dem, was die Schule prüft.“</x-raque.testimonial>
                <x-raque.testimonial name="Jonas" role="Schüler, 7. Klasse">„Minus mal minus gibt plus – ich hab's mit dem Schulden-Beispiel endlich verstanden. Die Erklärungen sind wie vom Lehrer, nur ohne Zeitdruck.“</x-raque.testimonial>
            </div>
        </div>
    </section>

    <x-raque.cta-banner title="Heute anfangen – der erste Test wartet schon." emphasis="Heute anfangen">
        <x-raque.button :href="auth()->check() ? (auth()->user()->isParent() ? route('parent.dashboard') : route('learn.index')) : route('login')" variant="on-primary" wire:navigate>Anmelden</x-raque.button>
    </x-raque.cta-banner>

    <x-raque.footer />

    @fluxScripts
</body>
</html>
