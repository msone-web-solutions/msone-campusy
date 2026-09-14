{{-- Wochenziel: erledigte Blöcke dieser Woche gegen das Ziel --}}
@props(['week', 'compact' => false])

@if ($week['goal'] > 0)
    <div {{ $attributes->merge(['class' => 'rq-weekgoal'.($week['reached'] ? ' is-reached' : '')]) }}>
        <div style="display:flex;justify-content:space-between;align-items:baseline;gap:10px;font-size:13px;margin-bottom:6px">
            <span><i class="bx {{ $week['reached'] ? 'bx-trophy' : 'bx-target-lock' }}" style="color:{{ $week['reached'] ? '#a2740a' : 'var(--color-icon)' }}"></i> Wochenziel</span>
            <span class="rq-num"><strong>{{ number_format($week['done_blocks'], 1, ',', '.') }}</strong> / {{ $week['goal'] }} Blöcke{{ $compact ? '' : ' · '.$week['topics'].' Themen' }}</span>
        </div>
        <div class="rq-progress" style="height:8px"><span style="width:{{ $week['percent'] }}%;{{ $week['reached'] ? 'background:var(--color-success)' : '' }}"></span></div>
        @unless ($compact)
            <p style="font-size:12px;margin-top:6px;line-height:1.5">{{ $week['reached'] ? 'Ziel erreicht – alles darüber ist Vorsprung.' : 'Noch '.number_format(max(0, $week['goal'] - $week['done_blocks']), 1, ',', '.').' Blöcke bis zum Wochenziel.' }}</p>
        @endunless
    </div>
@endif
