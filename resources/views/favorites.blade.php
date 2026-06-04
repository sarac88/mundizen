@php
    $favoritos = [
        [
            'category' => 'Energéticas',
            'icon'     => 'sparkles',
            'tag'      => 'reiki',
            'location' => 'Online · Online',
            'title'    => 'Reiki Usui — limpieza energética online',
            'initials' => 'IR',
            'author'   => 'Iván Romero',
            'rating'   => '4.8',
            'price'    => '30 €',
            'unit'     => '/ sesión',
        ],
        [
            'category' => 'Cursos',
            'icon'     => 'graduation-cap',
            'tag'      => 'mindfulness',
            'location' => 'Barcelona · Presencial',
            'title'    => 'Curso intensivo de mindfulness — 8 semanas',
            'initials' => 'LS',
            'author'   => 'Lucía Sanz',
            'rating'   => '5',
            'price'    => '280 €',
            'unit'     => '/ curso completo',
        ],
        [
            'category' => 'Manuales',
            'icon'     => 'hand',
            'tag'      => 'reflexología podal',
            'location' => 'Madrid · A domicilio',
            'title'    => 'Reflexología podal a domicilio',
            'initials' => 'DO',
            'author'   => 'Diego Ortiz',
            'rating'   => '4.7',
            'price'    => '55 €',
            'unit'     => '/ sesión',
        ],
        [
            'category' => 'Cursos',
            'icon'     => 'graduation-cap',
            'tag'      => 'iniciación al reiki',
            'location' => 'Online · Online',
            'title'    => 'Iniciación al Reiki — nivel I',
            'initials' => 'CM',
            'author'   => 'Clara Mata',
            'rating'   => '4.9',
            'price'    => '120 €',
            'unit'     => '/ curso completo',
        ],
    ];

    $catColor = [
        'Energéticas' => 'bg-brand-sand text-brand-sand-dark',
        'Cursos'      => 'bg-brand-sky text-brand-sky-dark',
        'Manuales'    => 'bg-brand-sage-soft text-brand-sage-dark',
        'Productos'   => 'bg-brand-coral text-brand-coral-dark',
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
        <p class="text-[15px] text-brand-text mt-2">Tienes {{ count($favoritos) }} anuncios guardados.</p>
    </div>

    {{-- Grid de tarjetas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($favoritos as $fav)
            <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] overflow-hidden flex flex-col">

                {{-- Foto --}}
                <div class="relative h-44 bg-brand-cream flex items-center justify-center" style="{{ $stripes }}">
                    <span class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $catColor[$fav['category']] }} text-[12px] font-medium">
                        <x-lucide :name="$fav['icon']" class="w-3.5 h-3.5" />{{ $fav['category'] }}
                    </span>
                    <button class="absolute top-3 right-3 w-8 h-8 rounded-full bg-brand-dark text-brand-cream flex items-center justify-center hover:opacity-90 transition" aria-label="Quitar de favoritos">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                        </svg>
                    </button>
                    <span class="text-[12px] text-brand-dark/35">[ {{ $fav['tag'] }} ]</span>
                </div>

                {{-- Cuerpo --}}
                <div class="p-5 flex flex-col flex-1">
                    <p class="text-[12px] text-brand-muted flex items-center gap-1 mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        {{ $fav['location'] }}
                    </p>

                    <h3 class="font-serif text-[19px] leading-snug tracking-tight mb-4">{{ $fav['title'] }}</h3>

                    {{-- Autor + valoración --}}
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-brand-dark/5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[10px] font-semibold flex items-center justify-center">{{ $fav['initials'] }}</div>
                            <span class="text-[13px] text-brand-text">{{ $fav['author'] }}</span>
                        </div>
                        <span class="flex items-center gap-1 text-[13px] text-brand-text">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                            {{ $fav['rating'] }}
                        </span>
                    </div>

                    {{-- Precio + CTA --}}
                    <div class="flex items-end justify-between mt-auto">
                        <div>
                            <p class="font-serif text-[22px] font-medium leading-none">{{ $fav['price'] }}</p>
                            <p class="text-[11px] text-brand-muted mt-1">{{ $fav['unit'] }}</p>
                        </div>
                        <a href="#" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-brand-dark text-brand-cream rounded-full text-[13px] font-medium hover:opacity-90 transition">
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

</x-dashboard>
