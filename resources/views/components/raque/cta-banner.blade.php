@props(['title'])

<section {{ $attributes->merge(['class' => 'rq-cta']) }}>
    <div class="rq-container rq-cta__inner">
        <h2>{{ $title }}</h2>
        <div>{{ $slot }}</div>
    </div>
</section>
