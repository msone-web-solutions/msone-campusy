<?php

use App\Enums\ProgressStatus;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Themen')] class extends Component
{
    public Subject $subject;

    public function mount(Subject $subject): void
    {
        $this->subject = $subject->load([
            'topicAreas.topics.progress' => fn ($q) => $q->where('user_id', auth()->id()),
        ]);
    }

    /**
     * The first topic the student has not passed yet – where "Weiter lernen" points to.
     */
    #[Computed]
    public function nextTopic(): ?Topic
    {
        return $this->subject->topicAreas
            ->flatMap->topics
            ->first(fn (Topic $topic) => $topic->progress->first()?->status !== ProgressStatus::Passed);
    }

    public function statusOf(Topic $topic): ?ProgressStatus
    {
        return $topic->progress->first()?->status;
    }

    public function passedCount(TopicArea $area): int
    {
        return $area->topics->filter(fn (Topic $topic) => $this->statusOf($topic) === ProgressStatus::Passed)->count();
    }
};
?>

<div>
    <x-raque.page-banner :title="$subject->name.' – Klasse '.$subject->grade" eyebrow="Sekundarschule Sachsen-Anhalt · Fachlehrplan 2019" :crumbs="[['label' => 'Dashboard', 'href' => route('dashboard')], ['label' => 'Fächer', 'href' => route('learn.index')], ['label' => $subject->name]]">
        <div style="margin-top:25px">
            @if ($this->nextTopic)
                <x-raque.button variant="on-primary" icon="bx bx-right-arrow-alt" :href="route('learn.topic', [$subject, $this->nextTopic->topicArea, $this->nextTopic])" wire:navigate>Weiter lernen: {{ $this->nextTopic->title }}</x-raque.button>
            @else
                <span class="rq-badge rq-badge--on-primary"><i class="bx bx-check-circle"></i>Alle Themen bestanden</span>
            @endif
        </div>
    </x-raque.page-banner>

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container" style="display:grid;gap:40px">
            @foreach ($subject->topicAreas as $area)
                <div wire:key="area-{{ $area->id }}">
                    <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:12px;margin-bottom:18px">
                        <div>
                            <span class="rq-eyebrow" style="margin-bottom:4px">Themenfeld {{ $area->sort }}</span>
                            <h2 style="font-size:26px;font-weight:600;line-height:1.3">{{ $area->name }}</h2>
                            <p style="max-width:620px;margin-top:6px">{{ $area->description }}</p>
                        </div>
                        <span class="rq-badge {{ $this->passedCount($area) === $area->topics->count() ? 'rq-badge--green' : '' }} rq-num"><i class="bx bx-check-circle"></i>{{ $this->passedCount($area) }}/{{ $area->topics->count() }} bestanden</span>
                    </div>

                    <ol class="rq-list rq-card">
                        @foreach ($area->topics as $topic)
                            @php $status = $this->statusOf($topic); @endphp
                            <li wire:key="topic-{{ $topic->id }}" class="rq-topic-row">
                                <a href="{{ route('learn.topic', [$subject, $area, $topic]) }}" wire:navigate class="rq-topic">
                                    <span @class(['rq-topic__nr', 'rq-topic__nr--done' => $status === ProgressStatus::Passed, 'rq-topic__nr--started' => $status !== null && $status !== ProgressStatus::Passed])>
                                        @if ($status === ProgressStatus::Passed)<i class="bx bx-check" style="font-size:22px"></i>@else{{ $area->sort }}.{{ $topic->sort }}@endif
                                    </span>
                                    <span style="min-width:0;flex:1">
                                        <span class="rq-topic__title">{{ $topic->title }}</span>
                                        <span class="rq-topic__intro">{{ $topic->intro }}</span>
                                    </span>
                                    <span class="rq-topic__side">
                                        @if ($status)<span class="rq-badge {{ $status === ProgressStatus::Passed ? 'rq-badge--green' : 'rq-badge--red' }}">{{ $status->label() }}</span>@endif
                                        <span><i class="bx bx-time"></i> {{ $topic->estimated_minutes }} min</span>
                                        <i class="bx bx-chevron-right" style="font-size:22px"></i>
                                    </span>
                                </a>
                                <a href="{{ route('learn.topic.worksheet', [$subject, $area, $topic]) }}" class="rq-topic__pdf" title="Probearbeit als PDF herunterladen" aria-label="Probearbeit {{ $area->sort }}.{{ $topic->sort }} als PDF"><i class="bx bxs-file-pdf"></i></a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endforeach
        </div>
    </section>
</div>
