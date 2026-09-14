<?php

use App\Models\ScheduleSetting;
use App\Models\Subject;
use App\Models\User;
use App\Schedule\Curriculum;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Stundenplan einstellen')] class extends Component
{
    #[Locked]
    public int $childId;

    public string $start_date = '';

    public string $day_start = '08:00';

    public int $blocks_per_day = 3;

    public int $lesson_minutes = 85;

    public int $break_minutes = 20;

    /** @var list<int> */
    public array $school_days = [1, 2, 3, 4, 5];

    /** @var array<string, int> */
    public array $subject_weights = [];

    public function mount(User $child): void
    {
        abort_unless($child->parent_id === auth()->id(), 404);

        $this->childId = $child->id;
        $settings = ScheduleSetting::for($child);

        $this->start_date = $settings->start_date->toDateString();
        $this->day_start = sprintf('%02d:%02d', intdiv($settings->day_start, 60), $settings->day_start % 60);
        $this->blocks_per_day = $settings->blocks_per_day;
        $this->lesson_minutes = $settings->lesson_minutes;
        $this->break_minutes = $settings->break_minutes;
        $this->school_days = array_map('intval', $settings->school_days);
        $this->subject_weights = $this->subjects->mapWithKeys(fn (Subject $s) => [$s->slug => $settings->weightFor($s)])->all();
    }

    #[Computed]
    public function child(): User
    {
        return User::query()->findOrFail($this->childId);
    }

    /**
     * @return Collection<int, Subject>
     */
    #[Computed]
    public function subjects(): Collection
    {
        return Subject::query()->orderBy('sort')->get();
    }

    /**
     * @return array<string, mixed>
     */
    #[Computed]
    public function pace(): array
    {
        return Curriculum::for($this->child)->pace(now());
    }

    public function save(): void
    {
        $validated = $this->validate([
            'start_date' => ['required', 'date'],
            'day_start' => ['required', 'date_format:H:i'],
            'blocks_per_day' => ['required', 'integer', 'between:1,5'],
            'lesson_minutes' => ['required', 'integer', 'between:45,120'],
            'break_minutes' => ['required', 'integer', 'between:5,45'],
            'school_days' => ['required', 'array', 'min:1'],
            'school_days.*' => ['integer', 'between:1,7'],
            'subject_weights' => ['array'],
            'subject_weights.*' => ['integer', 'between:1,3'],
        ]);

        [$h, $m] = explode(':', $validated['day_start']);

        ScheduleSetting::query()->updateOrCreate(['user_id' => $this->childId], [
            'start_date' => $validated['start_date'],
            'day_start' => (int) $h * 60 + (int) $m,
            'blocks_per_day' => $validated['blocks_per_day'],
            'lesson_minutes' => $validated['lesson_minutes'],
            'break_minutes' => $validated['break_minutes'],
            'school_days' => array_values(array_map('intval', $validated['school_days'])),
            'subject_weights' => array_map('intval', $validated['subject_weights'] ?? []),
        ]);

        unset($this->pace);
        Flux::toast(variant: 'success', text: 'Stundenplan gespeichert.');
    }
};
?>

<div>
    @php $pace = $this->pace; $child = $this->child; @endphp
    <x-raque.page-banner :title="'Stundenplan für '.$child->name" eyebrow="Rahmen & Tempo" :crumbs="[['label' => 'Elternübersicht', 'href' => route('parent.dashboard')], ['label' => 'Stundenplan']]">
        <p style="color:#fff;opacity:.9;margin-top:4px">Aus diesen Vorgaben rechnet Campusy Soll-Tempo, Rückstand und den Fertigstellungstermin. Änderungen wirken sofort.</p>
    </x-raque.page-banner>

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container" style="display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:30px;align-items:start">
            <x-raque.card title="Rahmen" pad>
                <form wire:submit="save" style="display:grid;gap:22px">
                    <div class="rq-grid rq-grid--2">
                        <div>
                            <flux:input wire:model="start_date" type="date" label="Startdatum (Soll-Rechnung ab)" />
                            <p style="font-size:12px;margin-top:4px">Ab hier zählt jeder Schultag {{ $blocks_per_day }} Blöcke als Soll.</p>
                        </div>
                        <flux:input wire:model="day_start" type="time" label="Schulbeginn" />
                    </div>

                    <div class="rq-grid rq-grid--3">
                        <flux:input wire:model="blocks_per_day" type="number" min="1" max="5" label="Doppelstunden pro Tag" />
                        <flux:input wire:model="lesson_minutes" type="number" min="45" max="120" step="5" label="Länge einer Doppelstunde (min)" />
                        <flux:input wire:model="break_minutes" type="number" min="5" max="45" step="5" label="Bewegungspause (min)" />
                    </div>

                    <div>
                        <flux:label>Schultage</flux:label>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:8px">
                            @foreach (['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'] as $i => $label)
                                <label class="rq-option" style="padding:8px 14px"><input type="checkbox" wire:model="school_days" value="{{ $i + 1 }}"> {{ $label }}</label>
                            @endforeach
                        </div>
                        @error('school_days')<p style="color:var(--color-danger);font-size:13px;margin-top:6px">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <flux:label>Fächer-Gewichtung</flux:label>
                        <p style="font-size:13px;margin:4px 0 10px">Gewicht 2 = dieses Fach kommt doppelt so oft dran wie ein Fach mit Gewicht 1.</p>
                        <div style="display:grid;gap:10px">
                            @foreach ($this->subjects as $subject)
                                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 14px;border:1px solid var(--border-default);border-radius:var(--radius-control)" wire:key="w-{{ $subject->slug }}">
                                    <span style="font-weight:500"><i class="{{ \App\Schedule\DayPlanner::subjectIcon($subject) }}" style="color:var(--color-icon);margin-right:6px"></i>{{ $subject->name }}</span>
                                    <div style="display:flex;gap:6px">
                                        @foreach ([1 => 'normal', 2 => 'doppelt', 3 => 'dreifach'] as $w => $wl)
                                            <label class="rq-option" style="padding:6px 12px;font-size:13px"><input type="radio" wire:model="subject_weights.{{ $subject->slug }}" value="{{ $w }}"> {{ $w }}× <span class="rq-muted">{{ $wl }}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:8px">
                        <x-raque.button variant="cancel" :href="route('parent.dashboard')" wire:navigate>Zurück</x-raque.button>
                        <x-raque.button type="submit" icon="bx bx-save">Speichern</x-raque.button>
                    </div>
                </form>
            </x-raque.card>

            <div style="display:grid;gap:20px">
                <x-raque.card title="Aktueller Lernstand">
                    <div class="rq-card__body" style="display:grid;gap:12px">
                        @if ($pace['backlog_blocks'] > 0)
                            <span class="rq-badge rq-badge--amber" style="font-size:13px;padding:6px 12px;justify-self:start"><i class="bx bx-error"></i>Rückstand: {{ $pace['backlog_blocks'] }} Blöcke · ≈ {{ number_format(abs($pace['backlog_days']), 1, ',', '.') }} Tage</span>
                        @elseif ($pace['backlog_blocks'] < 0)
                            <span class="rq-badge rq-badge--green" style="font-size:13px;padding:6px 12px;justify-self:start"><i class="bx bx-trending-up"></i>Vorsprung: {{ abs($pace['backlog_blocks']) }} Blöcke</span>
                        @else
                            <span class="rq-badge rq-badge--green" style="font-size:13px;padding:6px 12px;justify-self:start"><i class="bx bx-check-circle"></i>Im Plan</span>
                        @endif
                        <div class="rq-progress rq-pace" style="height:10px"><span class="rq-pace__soll" style="width:{{ $pace['percent_expected'] }}%"></span><span class="rq-pace__ist" style="width:{{ $pace['percent_done'] }}%"></span></div>
                        <ul class="rq-profile__stats" style="padding:0">
                            <li><span>Ist</span><span>{{ $pace['percent_done'] }} %</span></li>
                            <li><span>Soll heute</span><span>{{ $pace['percent_expected'] }} %</span></li>
                            <li><span>Offene Blöcke</span><span>{{ $pace['remaining_blocks'] }}</span></li>
                            <li><span>Schultage bis fertig</span><span>{{ $pace['school_days_left'] }}</span></li>
                            <li><span>Voraussichtlich fertig</span><span>{{ $pace['finish_date']?->format('d.m.Y') ?? '–' }}</span></li>
                        </ul>
                    </div>
                </x-raque.card>
                <div class="rq-callout"><i class="bx bx-bulb"></i><p style="font-size:13px;line-height:1.6">Soll = Schultage seit Startdatum × Blöcke pro Tag × Lernminuten je Block. Ist = Lernminuten der bestandenen Themen. Mehr Blöcke pro Tag verkürzen den Plan, ein späteres Startdatum löscht Rückstand.</p></div>
            </div>
        </div>
    </section>
</div>
