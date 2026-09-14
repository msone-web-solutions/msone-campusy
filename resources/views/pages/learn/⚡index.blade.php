<?php

use App\Enums\ProgressStatus;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Lernen')] class extends Component
{
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
        $passed = $topics->filter(fn ($topic) => $topic->progress->first()?->status === ProgressStatus::Passed)->count();

        return [
            'total' => $total,
            'passed' => $passed,
            'percent' => $total === 0 ? 0 : (int) round($passed * 100 / $total),
        ];
    }
};
?>

<div>
    <x-raque.page-banner title="Deine Fächer" eyebrow="Klasse 7 · Sekundarschule Sachsen-Anhalt" :crumbs="[['label' => 'Dashboard', 'href' => route('dashboard')], ['label' => 'Fächer']]" />

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container">
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
                        <p style="font-size:14px;margin-bottom:15px">{{ $subject->description }}</p>
                        <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-body);margin-bottom:8px"><span>Fortschritt</span><span class="rq-num">{{ $progress['percent'] }} %</span></div>
                        <div class="rq-progress"><span style="width: {{ $progress['percent'] }}%"></span></div>
                    </x-raque.course-card>
                @endforeach
            </div>

            @if ($this->subjects->isEmpty())
                <div class="rq-callout"><i class="bx bx-info-circle"></i><div><h4>Noch keine Fächer</h4><p>Inhalte werden mit <code>php artisan content:sync</code> eingelesen.</p></div></div>
            @endif
        </div>
    </section>
</div>
