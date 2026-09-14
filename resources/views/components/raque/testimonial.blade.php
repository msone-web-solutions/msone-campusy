@props(['name', 'role' => null, 'initials' => null])

<div {{ $attributes->merge(['class' => 'rq-testimonial']) }}>
    <div class="rq-testimonial__avatar" aria-hidden="true">{{ $initials ?? mb_substr($name, 0, 1) }}</div>
    <h3>{{ $name }}</h3>
    @if ($role)<span class="rq-testimonial__role">{{ $role }}</span>@endif
    <p>{{ $slot }}</p>
</div>
