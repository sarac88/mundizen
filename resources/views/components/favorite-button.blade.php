@props([
    'ad',
    'favorited' => null,
    'variant' => 'overlay',
])

@php
    $isFavorited = $favorited ?? (auth()->check() && $ad->isFavoritedBy(auth()->user()));

    $classes = match ($variant) {
        'filled' => 'shrink-0 w-8 h-8 rounded-full flex items-center justify-center hover:opacity-90 transition',
        'sidebar' => 'shrink-0 w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition',
        default => 'shrink-0 w-9 h-9 rounded-full border border-brand-dark/15 flex items-center justify-center transition',
    };

    $filledClasses = match ($variant) {
        'filled', 'overlay' => 'bg-brand-dark text-brand-cream',
        'sidebar' => 'bg-brand-dark text-brand-cream border-brand-dark',
        default => 'bg-brand-dark text-brand-cream',
    };

    $outlineClasses = match ($variant) {
        'filled' => 'bg-white/90 text-brand-text hover:text-brand-dark',
        'sidebar' => '',
        default => 'bg-white/90 text-brand-text hover:text-brand-dark',
    };

    $buttonClasses = \Illuminate\Support\Arr::toCssClasses([
        $classes,
        $isFavorited ? $filledClasses : $outlineClasses,
    ]);
@endphp

@if (auth()->check())
    <button
        type="button"
        data-favorite-toggle
        data-favorite-variant="{{ $variant }}"
        data-url="{{ route('favorites.toggle', $ad) }}"
        data-favorited="{{ $isFavorited ? '1' : '0' }}"
        aria-label="{{ $isFavorited ? 'Quitar de favoritos' : 'Guardar en favoritos' }}"
        {{ $attributes->merge(['class' => $buttonClasses]) }}
    >
        <svg data-favorite-icon-outline @class(['w-4 h-4', 'hidden' => $isFavorited]) fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
        <svg data-favorite-icon-filled @class(['w-4 h-4', 'hidden' => ! $isFavorited]) viewBox="0 0 24 24" fill="currentColor">
            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
        </svg>
    </button>
@else
    <a
        href="{{ route('login') }}"
        aria-label="Inicia sesión para guardar en favoritos"
        {{ $attributes->merge(['class' => \Illuminate\Support\Arr::toCssClasses([$classes, $outlineClasses])]) }}
    >
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
    </a>
@endif
