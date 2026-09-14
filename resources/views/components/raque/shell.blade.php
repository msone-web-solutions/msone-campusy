{{-- AppShell: sticky left rail | main feed | right rail --}}
@props(['left' => null, 'right' => null])

<div {{ $attributes->merge(['class' => 'rq-container rq-shell']) }}>
    @if ($left)
        <aside class="rq-shell__left"><div>{{ $left }}</div></aside>
    @endif
    <main class="rq-shell__main">{{ $slot }}</main>
    @if ($right)
        <aside class="rq-shell__right">{{ $right }}</aside>
    @endif
</div>
