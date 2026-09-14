@props(['value', 'label', 'suffix' => '+'])

<div {{ $attributes->merge(['class' => 'rq-funfact']) }}>
    <h3>{{ $value }}{{ $suffix }}</h3>
    <p>{{ $label }}</p>
</div>
