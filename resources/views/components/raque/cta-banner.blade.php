@props(['title', 'emphasis' => null])
@php $html = e($title); if ($emphasis && str_contains($title, $emphasis)) { $html = str_replace(e($emphasis), '<strong>'.e($emphasis).'</strong>', $html); } @endphp

<section {{ $attributes->merge(['class' => 'rq-cta']) }}>
    <div class="rq-container rq-cta__inner">
        <h2>{!! $html !!}</h2>
        <div>{{ $slot }}</div>
    </div>
</section>
