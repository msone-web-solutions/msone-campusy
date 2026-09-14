<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<title>Probearbeit – {{ $topic->title }}</title>
<style>
    @page { margin: 18mm 16mm 20mm 16mm; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10.5pt; color: #252525; line-height: 1.45; }
    .bar { height: 2.5mm; background: #ff1949; margin: 0 0 6mm; }
    .head { width: 100%; border-collapse: collapse; margin-bottom: 6mm; }
    .head td { vertical-align: top; padding: 0; }
    .eyebrow { font-size: 8.5pt; text-transform: uppercase; color: #ff1949; letter-spacing: .3px; }
    h1 { font-size: 17pt; margin: 1mm 0 1mm; line-height: 1.2; }
    .sub { font-size: 9pt; color: #727695; }
    .fields { width: 100%; border-collapse: collapse; margin: 4mm 0 6mm; font-size: 9.5pt; }
    .fields td { border-bottom: 1px solid #252525; padding: 0 0 1.5mm; }
    .fields .lbl { border: 0; padding-right: 2mm; white-space: nowrap; color: #727695; width: 1%; }
    .fields .sp { border: 0; width: 6mm; }
    .rules { background: #f3f3f3; border-left: 3px solid #ff1949; padding: 3mm 4mm; margin-bottom: 6mm; font-size: 9pt; color: #4a4d63; }
    .task { margin-bottom: 5mm; page-break-inside: avoid; }
    .task table { width: 100%; border-collapse: collapse; }
    .task .nr { width: 9mm; vertical-align: top; font-weight: bold; color: #ff1949; font-size: 11pt; }
    .task .pts { width: 16mm; text-align: right; vertical-align: top; font-size: 8.5pt; color: #727695; white-space: nowrap; }
    .task .hint { font-size: 8.5pt; color: #727695; margin-bottom: 1.5mm; }
    .prompt { font-size: 11pt; }
    .prompt strong { font-weight: bold; }
    .gap { display: inline-block; width: 26mm; border-bottom: 1px solid #252525; height: 4mm; margin: 0 1mm; }
    ul.opts { list-style: none; margin: 2mm 0 0; padding: 0; }
    ul.opts li { margin: 0 0 1.4mm 0; }
    .box { display: inline-block; width: 3.6mm; height: 3.6mm; border: 1px solid #252525; border-radius: 1px; margin-right: 2.5mm; vertical-align: -0.6mm; }
    .answer { margin-top: 2.5mm; font-size: 9pt; color: #727695; }
    .answer .line { display: inline-block; width: 45mm; border-bottom: 1px solid #252525; height: 4mm; margin: 0 2mm; }
    .work { height: 14mm; border-bottom: 1px dotted #b8bacb; }
    .work.tall { height: 22mm; }
    .foot { position: fixed; bottom: -13mm; left: 0; right: 0; height: 9mm; overflow: hidden; font-size: 8pt; color: #727695; border-top: 1px solid #e6e9fc; padding-top: 1.5mm; text-align: left; }
    .foot table { width: 100%; border-collapse: collapse; }
    .foot td { padding: 0; font-size: 8pt; color: #727695; }
    .foot td.r { text-align: right; white-space: nowrap; }
    .solutions { page-break-before: always; }
    .solutions h2 { font-size: 14pt; margin: 0 0 1mm; }
    .solutions table { width: 100%; border-collapse: collapse; font-size: 9.5pt; }
    .solutions th { text-align: left; border-bottom: 2px solid #e6e9fc; padding: 1.5mm 2mm; font-size: 8.5pt; text-transform: uppercase; color: #727695; }
    .solutions td { border-bottom: 1px solid #e2f4ff; padding: 1.8mm 2mm; vertical-align: top; }
    .solutions td.n { width: 8mm; font-weight: bold; color: #ff1949; }
    .solutions td.s { width: 42mm; font-weight: bold; }
    .solutions td.e { color: #4a4d63; }
    .grades { margin-top: 5mm; font-size: 9pt; color: #4a4d63; }
    .grades table { width: auto; border-collapse: collapse; margin-top: 1.5mm; }
    .grades td, .grades th { border: 1px solid #e6e9fc; padding: 1mm 3mm; text-align: center; font-size: 9pt; }
</style>
</head>
<body>
<div class="foot">
    <table><tr>
        <td>Probearbeit {{ $area->sort }}.{{ $topic->sort }} · {{ $topic->title }} · Inhalte nach Fachlehrplan Sachsen-Anhalt (CC BY-SA 3.0)</td>
        <td class="r">Campusy</td>
    </tr></table>
</div>
<div class="bar"></div>

<table class="head">
    <tr>
        <td>
            <div class="eyebrow">Probearbeit · {{ $subject->name }} Klasse {{ $subject->grade }} · Themenfeld {{ $area->sort }}: {{ $area->name }}</div>
            <h1>{{ $topic->title }}</h1>
            <div class="sub">Sekundarschule Sachsen-Anhalt · Fachlehrplan Mathematik, Schuljahrgänge 7/8 · {{ $tasks->count() }} Aufgaben · {{ $totalPoints }} Punkte</div>
        </td>
        <td style="width:34mm;text-align:right;font-size:8.5pt;color:#727695">Campusy<br>{{ now()->format('d.m.Y') }}</td>
    </tr>
</table>

<table class="fields">
    <tr>
        <td class="lbl">Name:</td><td></td>
        <td class="sp"></td>
        <td class="lbl">Datum:</td><td style="width:32mm"></td>
        <td class="sp"></td>
        <td class="lbl">Punkte:</td><td style="width:28mm;text-align:right">&nbsp;/ {{ $totalPoints }}</td>
    </tr>
</table>

<div class="rules">
    <strong>So geht's:</strong> Bearbeite alle Aufgaben ohne Taschenrechner. Schreibe Rechenwege auf die gepunkteten Linien oder auf ein Extrablatt.
    Dezimalzahlen mit Komma (−2,5), Brüche mit Bruchstrich oder Schrägstrich (3/4). Bestanden ab {{ $topic->pass_percent }} % der Punkte.
    Die Lösungen stehen auf der letzten Seite – erst nach dem Bearbeiten anschauen!
</div>

@foreach ($tasks as $task)
    <div class="task">
        <table>
            <tr>
                <td class="nr">{{ $task['nr'] }}.</td>
                <td>
                    <div class="hint">{{ $task['hint'] }}</div>
                    <div class="prompt">{!! $task['prompt'] !!}</div>

                    @if ($task['type'] === \App\Enums\QuestionType::SingleChoice || $task['type'] === \App\Enums\QuestionType::MultipleChoice)
                        <ul class="opts">
                            @foreach ($task['options'] as $opt)
                                <li><span class="box"></span>{!! $opt !!}</li>
                            @endforeach
                        </ul>
                    @elseif ($task['type'] === \App\Enums\QuestionType::TrueFalse)
                        <ul class="opts">
                            <li><span class="box"></span>wahr</li>
                            <li><span class="box"></span>falsch</li>
                        </ul>
                    @elseif ($task['type'] === \App\Enums\QuestionType::Numeric)
                        <div class="work tall"></div>
                        <div class="answer">Ergebnis: <span class="line"></span>{{ $task['unit'] }}</div>
                    @else
                        <div class="work"></div>
                    @endif
                </td>
                <td class="pts">{{ $task['points'] }} {{ $task['points'] === 1 ? 'Punkt' : 'Punkte' }}</td>
            </tr>
        </table>
    </div>
@endforeach

<div class="solutions">
    <div class="eyebrow">Lösungsblatt</div>
    <h2>{{ $topic->title }}</h2>
    <div class="sub" style="margin-bottom:4mm">Zum Selbstkontrollieren oder für die Eltern. Jede richtige Aufgabe gibt die angegebenen Punkte.</div>
    <table>
        <tr><th>Nr.</th><th>Lösung</th><th>Erklärung</th></tr>
        @foreach ($tasks as $task)
            <tr>
                <td class="n">{{ $task['nr'] }}</td>
                <td class="s">{!! $task['solution'] !!}</td>
                <td class="e">{!! $task['explanation'] ?? '' !!}</td>
            </tr>
        @endforeach
    </table>

    @php
        $steps = [
            ['Note 1', 92], ['Note 2', 80], ['Note 3', 65], ['Note 4', 50], ['Note 5', 25], ['Note 6', 0],
        ];
    @endphp
    <div class="grades">
        <strong>Bewertung (Orientierung):</strong> Punkte ab …
        <table>
            <tr>@foreach ($steps as [$label, $pct])<th>{{ $label }}</th>@endforeach</tr>
            <tr>@foreach ($steps as [$label, $pct])<td>{{ (int) ceil($totalPoints * $pct / 100) }}</td>@endforeach</tr>
        </table>
    </div>
</div>


</body>
</html>
