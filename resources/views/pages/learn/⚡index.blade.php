<?php

use App\Enums\ProgressStatus;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Title('Lernen')] class extends Component
{
    #[Url(as: 'q', except: '')]
    public string $q = '';

    #[Computed]
    public function settings(): \App\Models\ScheduleSetting
    {
        return \App\Models\ScheduleSetting::for(auth()->user());
    }

    /**
     * Volltextsuche über Titel, Einleitung, Erklärung, Hefteintrag, Themenfeld und Fach.
     * Alle Suchwörter müssen vorkommen; Treffer im Titel stehen vorn.
     *
     * @return Collection<int, Topic>
     */
    #[Computed]
    public function results(): Collection
    {
        $terms = collect(preg_split('/\s+/u', trim($this->q)) ?: [])->filter(fn ($t) => mb_strlen($t) >= 2)->values();

        if ($terms->isEmpty()) {
            return collect();
        }

        $query = Topic::query()
            ->join('topic_areas', 'topic_areas.id', '=', 'topics.topic_area_id')
            ->join('subjects', 'subjects.id', '=', 'topic_areas.subject_id')
            ->select('topics.*')
            ->with(['topicArea.subject', 'progress' => fn ($q) => $q->where('user_id', auth()->id())])
            ->orderBy('subjects.sort')->orderBy('topic_areas.sort')->orderBy('topics.sort');

        foreach ($terms as $term) {
            $like = '%'.str_replace(['%', '_'], ['\\%', '\\_'], $term).'%';
            $query->where(fn ($w) => $w
                ->where('topics.title', 'like', $like)
                ->orWhere('topics.intro', 'like', $like)
                ->orWhere('topics.explanation', 'like', $like)
                ->orWhere('topics.notebook_entry', 'like', $like)
                ->orWhere('topic_areas.name', 'like', $like)
                ->orWhere('subjects.name', 'like', $like));
        }

        $first = mb_strtolower((string) $terms->first());

        return $query->limit(60)->get()
            ->sortBy(fn (Topic $t) => str_contains(mb_strtolower($t->title), $first) ? 0 : 1, SORT_NUMERIC, false)
            ->values();
    }

    public function clear(): void
    {
        $this->q = '';
    }

    /**
     * @return Collection<int, Subject>
     */
    #[Computed]
    public function subjects(): Collection
    {
        return Subject::query()
            ->orderBy('sort')
            ->with(['topicAreas.topics.progress' => fn ($q) => $q->where('user_id', auth()->id())])
            ->get();
    }

    /**
     * @return array{total: int, passed: int, percent: int}
     */
    public function progressFor(Subject $subject): array
    {
        $topics = $subject->topicAreas->flatMap->topics;
        $total = $topics->count();
        $passed = $topics->filter(fn ($topic) => $topic->progress->first()?->status->isPassed() ?? false)->count();

        return [
            'total' => $total,
            'passed' => $passed,
            'percent' => $total === 0 ? 0 : (int) round($passed * 100 / $total),
        ];
    }
};
?>

<div>
    <x-raque.page-banner title="Deine Fächer." :emphasis="true" eyebrow="Klasse 7 · Sekundarschule Sachsen-Anhalt" :crumbs="[['label' => 'Dashboard', 'href' => route('dashboard')], ['label' => 'Fächer']]" />

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container">
            <form class="rq-search" role="search" wire:submit.prevent>
                <i class="bx bx-search rq-search__icon"></i>
                <input type="search" wire:model.live.debounce.300ms="q" placeholder="Thema, Begriff oder Fach suchen …" aria-label="Themen durchsuchen" autocomplete="off">
                @if ($q !== '')<button type="button" class="rq-search__clear" wire:click="clear" aria-label="Suche löschen"><i class="bx bx-x"></i></button>@endif
            </form>

            @if (trim($q) !== '')
                <div class="rq-search__results" wire:loading.class="is-loading" wire:target="q">
                    <div style="display:flex;flex-wrap:wrap;align-items:baseline;justify-content:space-between;gap:12px;margin-bottom:14px">
                        <h2 style="font-size:22px;font-weight:600">{{ $this->results->count() }} {{ $this->results->count() === 1 ? 'Treffer' : 'Treffer' }} für „{{ trim($q) }}“</h2>
                        <button type="button" class="rq-link" wire:click="clear"><i class="bx bx-x"></i> Alle Fächer anzeigen</button>
                    </div>

                    @if ($this->results->isEmpty())
                        <div class="rq-callout"><i class="bx bx-search-alt"></i><div><h4>Nichts gefunden</h4><p>Versuch es mit einem anderen Begriff – z. B. dem Namen eines Themas, eines Fachs oder einem Stichwort aus dem Hefteintrag.</p></div></div>
                    @else
                        <ol class="rq-list rq-card">
                            @foreach ($this->results as $topic)
                                @php $status = $topic->progress->first()?->status; $area = $topic->topicArea; $subject = $area->subject; @endphp
                                <li wire:key="hit-{{ $topic->id }}" class="rq-topic-row">
                                    <a href="{{ route('learn.topic', [$subject, $area, $topic]) }}" wire:navigate class="rq-topic">
                                        <span @class(['rq-topic__nr', 'rq-topic__nr--done' => $status?->isPassed(), 'rq-topic__nr--started' => $status !== null && ! $status->isPassed()])>
                                            @if ($status?->isPassed())<i class="bx bx-check" style="font-size:22px"></i>@else<i class="{{ \App\Schedule\DayPlanner::subjectIcon($subject) }}" style="font-size:20px"></i>@endif
                                        </span>
                                        <span style="min-width:0;flex:1">
                                            <span class="rq-eyebrow" style="font-size:12px;margin-bottom:2px">{{ $subject->name }} · {{ $area->name }}</span>
                                            <span class="rq-topic__title">{{ $topic->title }}</span>
                                            <span class="rq-topic__intro">{{ $topic->intro }}</span>
                                        </span>
                                        <span class="rq-topic__side">
                                            @if ($status)<span class="rq-badge {{ $status->isPassed() ? 'rq-badge--green' : 'rq-badge--red' }}">{{ $status->label() }}</span>@endif
                                            <span><i class="bx bx-time"></i> {{ $topic->estimated_minutes }} min</span>
                                            <i class="bx bx-chevron-right" style="font-size:22px"></i>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            @else
            <div class="rq-grid rq-grid--3">
                @foreach ($this->subjects as $subject)
                    @php $progress = $this->progressFor($subject); @endphp
                    <x-raque.course-card wire:key="subject-{{ $subject->id }}"
                        :title="$subject->name.' – Klasse '.$subject->grade"
                        :href="route('learn.subject', $subject)"
                        category="Sekundarschule Sachsen-Anhalt"
                        :icon="$subject->slug === 'mathematik' ? 'bx bx-math' : 'bx bx-book-open'"
                        :meta="[
                            ['icon' => 'bx bx-folder', 'label' => $subject->topicAreas->count().' Themenfelder'],
                            ['icon' => 'bx bx-book', 'label' => $progress['total'].' Themen'],
                            ['icon' => 'bx bx-check-circle', 'label' => $progress['passed'].' bestanden'],
                        ]">
                        @unless ($this->settings->isEnabled($subject))<p style="margin-bottom:10px"><span class="rq-badge"><i class="bx bx-pause-circle"></i>Nicht im Stundenplan</span></p>@endunless
                        <p style="font-size:14px;margin-bottom:15px">{{ $subject->description }}</p>
                        <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-body);margin-bottom:8px"><span>Fortschritt</span><span class="rq-num">{{ $progress['percent'] }} %</span></div>
                        <div class="rq-progress"><span style="width: {{ $progress['percent'] }}%"></span></div>
                    </x-raque.course-card>
                @endforeach
            </div>

            @if ($this->subjects->isEmpty())
                <div class="rq-callout"><i class="bx bx-info-circle"></i><div><h4>Noch keine Fächer</h4><p>Inhalte werden mit <code>php artisan content:sync</code> eingelesen.</p></div></div>
            @endif
            @endif
        </div>
    </section>
</div>
