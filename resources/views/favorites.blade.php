@php
    $catColor = [
        'Manuales' => 'bg-brand-sage-soft text-brand-sage-dark',
        'Energéticas' => 'bg-brand-sand text-brand-sand-dark',
        'Cursos' => 'bg-brand-sky text-brand-sky-dark',
        'Productos' => 'bg-brand-coral text-brand-coral-dark',
    ];
    $catIcon = [
        'Manuales' => 'hand',
        'Energéticas' => 'sparkles',
        'Cursos' => 'graduation-cap',
        'Productos' => 'droplet',
    ];
    $stripes = 'background-image: repeating-linear-gradient(45deg, transparent, transparent 9px, rgba(42,61,54,0.05) 9px, rgba(42,61,54,0.05) 10px);';
@endphp

<x-dashboard title="Favoritos" active="favoritos">

    {{-- Encabezado --}}
    <div class="mb-7">
        <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">TUS GUARDADOS —</p>
        <h1 class="font-serif font-normal text-4xl lg:text-[40px] tracking-tight">
            Anuncios para <span class="italic text-brand-sage">volver más tarde.</span>
        </h1>
        <p class="text-[15px] text-brand-text mt-2">
            Tienes <span data-favorites-count>{{ $ads->count() }}</span> anuncios guardados.
        </p>
    </div>

    @if ($ads->isEmpty())
        <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_1px_4px_rgba(42,61,54,0.07)] p-12 text-center">
            <p class="font-serif text-[26px] tracking-tight mb-2">Aún no tienes favoritos</p>
            <p class="text-[14px] text-brand-text mb-6">Guarda anuncios desde la búsqueda para encontrarlos aquí.</p>
            <a href="{{ route('search') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                Explorar anuncios
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" data-favorites-grid>
            @foreach ($ads as $ad)
                @php $categoryName = $ad->categoryLabel(); @endphp
                <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_1px_4px_rgba(42,61,54,0.07)] overflow-hidden flex flex-col" data-favorite-card>

                    {{-- Foto --}}
                    <div class="relative h-44 bg-brand-cream flex items-center justify-center overflow-hidden" style="{{ $stripes }}">
                        @if ($ad->mainPhoto)
                            <img src="{{ $ad->mainPhoto->url }}" alt="{{ $ad->title }}" class="absolute inset-0 z-0 w-full h-full object-cover">
                        @endif

                        @if ($categoryName)
                            <span class="absolute top-3 left-3 z-10 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $catColor[$categoryName] ?? 'bg-brand-sage-soft text-brand-sage-dark' }} text-[12px] font-medium">
                                <x-lucide :name="$catIcon[$categoryName] ?? 'hand'" class="w-3.5 h-3.5" />{{ $categoryName }}
                            </span>
                        @endif

                    </div>

                    {{-- Cuerpo --}}
                    <div class="p-5 flex flex-col flex-1 relative">
                        <x-favorite-button :ad="$ad" :favorited="true" variant="filled" class="absolute top-3 right-4 z-10" />
                        @if ($ad->locationLabel())
                            <p class="text-[12px] text-brand-muted flex items-center gap-1 mb-2">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $ad->locationLabel() }}
                            </p>
                        @endif

                        <h3 class="font-serif text-[19px] leading-snug tracking-tight mb-4">{{ $ad->title }}</h3>

                        <div class="flex items-center gap-2 pb-4 mb-4 border-b border-brand-dark/5">
                            <div class="w-7 h-7 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[10px] font-semibold flex items-center justify-center">{{ $ad->user->initials() }}</div>
                            <span class="text-[13px] text-brand-text">{{ $ad->user->name }}</span>
                        </div>

                        <div class="flex items-end justify-between mt-auto">
                            <div>
                                <p class="font-serif text-[22px] font-medium leading-none">{{ $ad->formattedPrice() }}</p>
                                @if ($ad->priceUnitLabel())
                                    <p class="text-[11px] text-brand-muted mt-1">{{ $ad->priceUnitLabel() }}</p>
                                @endif
                            </div>
                            <a href="{{ route('listing', $ad) }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-brand-dark text-brand-cream rounded-full text-[13px] font-medium hover:opacity-90 transition">
                                Ver
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <x-favorite-toggle-script />
</x-dashboard>
