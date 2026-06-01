@props([
    'status',
])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-brand-sage-dark']) }}>
        {{ $status }}
    </div>
@endif
