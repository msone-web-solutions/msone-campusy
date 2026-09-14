@props(['question', 'disabled' => false, 'compact' => false])

@php
    use App\Enums\QuestionType;
    use App\Support\Markdown;
    $q = $question;
    $uid = 'q'.$q->id.'-'.spl_object_id($q);
@endphp

@if ($q->type !== QuestionType::GapText)
    <div class="lesson-prose" style="font-family:var(--font-ui);font-size:{{ $compact ? '16px' : '19px' }};font-weight:500;color:var(--text-heading);margin-bottom:{{ $compact ? '14px' : '25px' }};max-width:none">{!! Markdown::inline($q->prompt) !!}</div>
@endif

<fieldset @disabled($disabled) style="border:0;padding:0;margin:0;display:grid;gap:{{ $compact ? '8px' : '10px' }}">
    @switch($q->type)
        @case(QuestionType::SingleChoice)
            @foreach ($q->options as $i => $option)
                <label class="rq-option" wire:key="opt-{{ $uid }}-{{ $i }}">
                    <input type="radio" name="given-{{ $uid }}" value="{{ $i }}" wire:model="given">
                    <span>{!! Markdown::inline($option) !!}</span>
                </label>
            @endforeach
            @break

        @case(QuestionType::MultipleChoice)
            @foreach ($q->options as $i => $option)
                <label class="rq-option" wire:key="opt-{{ $uid }}-{{ $i }}">
                    <input type="checkbox" value="{{ $i }}" wire:model="given">
                    <span>{!! Markdown::inline($option) !!}</span>
                </label>
            @endforeach
            @break

        @case(QuestionType::TrueFalse)
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px">
                <label class="rq-option"><input type="radio" name="given-{{ $uid }}" value="true" wire:model="given"><i class="bx bx-check" style="font-size:20px;color:var(--color-secondary)"></i><span>Wahr</span></label>
                <label class="rq-option"><input type="radio" name="given-{{ $uid }}" value="false" wire:model="given"><i class="bx bx-x" style="font-size:20px;color:var(--color-primary)"></i><span>Falsch</span></label>
            </div>
            @break

        @case(QuestionType::Numeric)
            <div style="display:flex;align-items:center;gap:12px;max-width:360px">
                <input id="numeric-{{ $uid }}" class="rq-input" style="font-size:18px" type="text" inputmode="text" autocomplete="off" placeholder="Ergebnis" wire:model="given" wire:keydown.enter="check">
                @if (! empty($q->options['unit']))<span style="font-size:18px;color:var(--text-body)">{{ $q->options['unit'] }}</span>@endif
            </div>
            <span class="rq-muted" style="font-size:13px">Komma für Dezimalzahlen (−2,5), Schrägstrich für Brüche (-3/4).</span>
            @break

        @case(QuestionType::GapText)
            <div style="font-size:{{ $compact ? '16px' : '19px' }};font-weight:500;line-height:2.4;color:var(--text-heading)">
                @foreach (explode('___', $q->prompt) as $i => $part)
                    <span>{!! Markdown::inline($part) !!}</span>
                    @if (! $loop->last)
                        <input id="gap-{{ $uid }}-{{ $i }}" type="text" class="rq-gap" wire:model="given.{{ $i }}" wire:keydown.enter="check" autocomplete="off">
                    @endif
                @endforeach
            </div>
            @break
    @endswitch
</fieldset>
