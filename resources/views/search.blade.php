<x-public title="Buscar terapias">

    @php
        $activeCategory = request('category');
        $activeMode = request('mode');
        $activeSort = request('sort', '');
        $maxPrice = (int) request('max_price', 300);

        $sortLabels = [
            '' => 'Relevancia',
            'price_asc' => 'Precio ↑',
            'price_desc' => 'Precio ↓',
        ];

        $categoryFilters = [
            ['slug' => null, 'name' => 'Todas', 'icon' => null],
            ['slug' => 'manuales', 'name' => 'Manuales', 'icon' => 'hand'],
            ['slug' => 'energeticas', 'name' => 'Energéticas', 'icon' => 'sparkles'],
            ['slug' => 'cursos', 'name' => 'Cursos', 'icon' => 'graduation-cap'],
            ['slug' => 'productos', 'name' => 'Productos', 'icon' => 'droplet'],
        ];

        $modeFilters = [
            ['slug' => null, 'label' => 'Todas'],
            ['slug' => 'presencial', 'label' => 'Presencial'],
            ['slug' => 'online', 'label' => 'Online'],
            ['slug' => 'domicilio', 'label' => 'A domicilio'],
        ];

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

        $availability = ['Cualquier momento', 'Hoy', 'Esta semana', 'Este fin de semana'];
        $stripes = 'background-image: repeating-linear-gradient(45deg, transparent, transparent 9px, rgba(42,61,54,0.05) 9px, rgba(42,61,54,0.05) 10px);';

        $preserveQuery = fn (array $overrides = []) => request()->fullUrlWithQuery(array_merge(request()->query(), $overrides));
    @endphp

    {{-- ===== Cabecera + buscador ===== --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-9 pt-8 pb-6">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <div>
                <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">EXPLORA —</p>
                <h1 class="font-serif font-normal text-4xl lg:text-[44px] tracking-tight">
                    Encuentra tu <span class="italic text-brand-sage">terapia.</span>
                </h1>
            </div>

            <form method="GET" action="{{ route('search') }}" class="bg-white p-2 rounded-full flex items-center gap-1.5 shadow-[0_8px_32px_rgba(42,61,54,0.08)] w-full lg:w-[440px]">
                @if ($activeCategory)
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif
                @if ($activeMode)
                    <input type="hidden" name="mode" value="{{ $activeMode }}">
                @endif
                @if ($activeSort)
                    <input type="hidden" name="sort" value="{{ $activeSort }}">
                @endif
                @if (request('city'))
                    <input type="hidden" name="city" value="{{ request('city') }}">
                @endif
                @if (request()->has('max_price'))
                    <input type="hidden" name="max_price" value="{{ $maxPrice }}">
                @endif

                <div class="flex items-center gap-2 flex-1 px-4">
                    <svg class="w-4 h-4 text-brand-sage" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar masaje, reiki, mindfulness..." class="flex-1 bg-transparent text-[13px] text-brand-dark placeholder:text-brand-muted focus:outline-none">
                </div>
                <button type="submit" class="bg-brand-dark text-brand-cream px-6 py-3 rounded-full text-[13px] font-medium hover:opacity-90 transition flex items-center gap-1.5 shrink-0">
                    Buscar
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- ===== Filtros + resultados ===== --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-9 pb-16 grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-start">

        {{-- ===== Filtros ===== --}}
        <aside class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-5 lg:sticky lg:top-24">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-serif text-[20px] tracking-tight">Filtros</h2>
                <a href="{{ route('search') }}" class="text-[13px] text-brand-text hover:text-brand-dark transition">Limpiar</a>
            </div>

            {{-- Categoría --}}
            <div>
                <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">CATEGORÍA</p>
                <div class="flex flex-col gap-1">
                    @foreach ($categoryFilters as $cat)
                        @php $isActive = $activeCategory === $cat['slug'] || ($cat['slug'] === null && ! $activeCategory); @endphp
                        <a href="{{ $preserveQuery(['category' => $cat['slug'], 'page' => null]) }}" @class([
                            'flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[14px] transition',
                            'bg-brand-dark text-brand-cream font-medium' => $isActive,
                            'text-brand-text hover:bg-brand-sage-soft/50' => ! $isActive,
                        ])>
                            @if ($isActive)
                                <span class="w-2 h-2 rounded-full bg-brand-sage"></span>
                            @elseif ($cat['icon'])
                                <x-lucide :name="$cat['icon']" class="w-[18px] h-[18px]" />
                            @endif
                            {{ $cat['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Ciudad + precio --}}
            <form method="GET" action="{{ route('search') }}" class="border-t border-brand-dark/5 mt-5 pt-5">
                @if (request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                @if ($activeCategory)
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif
                @if ($activeMode)
                    <input type="hidden" name="mode" value="{{ $activeMode }}">
                @endif
                @if ($activeSort)
                    <input type="hidden" name="sort" value="{{ $activeSort }}">
                @endif

                <div>
                    <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">CIUDAD</p>
                    <div class="relative">
                        <select name="city" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 pr-10 rounded-xl border border-brand-dark/10 bg-transparent text-[14px] text-brand-dark focus:outline-none focus:border-brand-dark/25">
                            <option value="">Todas las ciudades</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 text-brand-muted absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                {{-- Modalidad --}}
                <div class="border-t border-brand-dark/5 mt-5 pt-5">
                    <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">MODALIDAD</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($modeFilters as $modeFilter)
                            @php $isActive = $activeMode === $modeFilter['slug'] || ($modeFilter['slug'] === null && ! $activeMode); @endphp
                            <a href="{{ $preserveQuery(['mode' => $modeFilter['slug'], 'page' => null]) }}" @class([
                                'px-4 py-2 rounded-full text-[13px] transition',
                                'bg-brand-dark text-brand-cream font-medium' => $isActive,
                                'border border-brand-dark/15 text-brand-text hover:bg-brand-sage-soft/40' => ! $isActive,
                            ])>{{ $modeFilter['label'] }}</a>
                        @endforeach
                    </div>
                </div>

                {{-- Precio --}}
                <div class="border-t border-brand-dark/5 mt-5 pt-5">
                    <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">PRECIO MÁX.</p>
                    <div class="flex items-center justify-between text-[13px] text-brand-text mb-2">
                        <span>0 €</span>
                        <span id="max-price-label">{{ $maxPrice }} €</span>
                    </div>
                    <input type="range" name="max_price" min="0" max="300" value="{{ $maxPrice }}" class="w-full accent-brand-dark" oninput="document.getElementById('max-price-label').textContent = this.value + ' €'" onchange="this.form.submit()">
                </div>
            </form>

            {{-- Disponibilidad (visual) --}}
            <div class="border-t border-brand-dark/5 mt-5 pt-5">
                <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">DISPONIBILIDAD</p>
                <div class="flex flex-col gap-1">
                    @foreach ($availability as $i => $avail)
                        <span @class([
                            'flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[14px]',
                            'bg-brand-dark/5 text-brand-muted' => $i === 0,
                            'text-brand-muted' => $i !== 0,
                        ])>
                            @if ($i === 0)
                                <span class="w-2 h-2 rounded-full bg-brand-sage"></span>
                            @else
                                <span class="w-3.5 h-3.5 rounded-full border border-brand-dark/25"></span>
                            @endif
                            {{ $avail }}
                        </span>
                    @endforeach
                </div>
                <p class="text-[11px] text-brand-muted mt-2">Próximamente</p>
            </div>
        </aside>

        {{-- ===== Resultados ===== --}}
        <div>
            <div class="flex items-center justify-between mb-5">
                <p class="text-[14px] text-brand-text">
                    <span class="font-serif text-[18px] font-medium">{{ $ads->total() }}</span> resultados
                </p>

                <details class="relative group">
                    <summary class="list-none flex items-center gap-2 px-4 py-2 rounded-full border border-brand-dark/10 text-[13px] text-brand-text cursor-pointer hover:text-brand-dark transition [&::-webkit-details-marker]:hidden">
                        <span>Ordenar por: <span class="text-brand-dark font-medium">{{ $sortLabels[$activeSort] ?? 'Relevancia' }}</span></span>
                        <svg class="w-3.5 h-3.5 transition group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </summary>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl border border-brand-dark/5 shadow-[0_12px_40px_rgba(42,61,54,0.12)] p-1.5 z-30">
                        @foreach ($sortLabels as $sortValue => $sortLabel)
                            <a href="{{ $preserveQuery(['sort' => $sortValue ?: null, 'page' => null]) }}" @class([
                                'flex items-center justify-between px-3 py-2 rounded-xl text-[13px] transition',
                                'text-brand-dark bg-brand-sage-soft/50' => $activeSort === $sortValue,
                                'text-brand-text hover:bg-brand-sage-soft/40' => $activeSort !== $sortValue,
                            ])>
                                {{ $sortLabel }}
                                @if ($activeSort === $sortValue)
                                    <svg class="w-3.5 h-3.5 text-brand-sage-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </details>
            </div>

            @if ($ads->isEmpty())
                <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-12 text-center">
                    <p class="font-serif text-[26px] tracking-tight mb-2">No hay anuncios que coincidan</p>
                    <p class="text-[14px] text-brand-text mb-6">Prueba a ampliar los filtros o buscar con otros términos.</p>
                    <a href="{{ route('search') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                        Ver todos los anuncios
                    </a>
                </div>
            @else
                <div class="flex flex-col gap-5">
                    @foreach ($ads as $ad)
                        @php
                            $categoryName = $ad->categoryLabel();
                            $tags = $ad->displayTags();
                        @endphp
                        <article class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] overflow-hidden grid grid-cols-1 lg:grid-cols-2">

                            {{-- Foto --}}
                            <div class="relative min-h-[300px] lg:min-h-[360px] bg-brand-cream flex items-center justify-center overflow-hidden" style="{{ $stripes }}">
                                @if ($ad->mainPhoto)
                                    <img src="{{ $ad->mainPhoto->url }}" alt="{{ $ad->title }}" class="absolute inset-0 z-0 w-full h-full object-cover">
                                @endif

                                <div class="absolute top-4 left-4 flex items-center gap-2 z-10">
                                    @if ($categoryName)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $catColor[$categoryName] ?? 'bg-brand-sage-soft text-brand-sage-dark' }} text-[12px] font-medium">
                                            <x-lucide :name="$catIcon[$categoryName] ?? 'hand'" class="w-3.5 h-3.5" />{{ $categoryName }}
                                        </span>
                                    @endif
                                    @if ($ad->isVerified())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-brand-dark text-brand-cream text-[12px] font-medium">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            Verificado
                                        </span>
                                    @endif
                                </div>
                                <x-favorite-button :ad="$ad" :favorited="in_array($ad->id, $favoriteIds, true)" class="absolute top-4 right-4 z-20" />
                                @unless ($ad->mainPhoto)
                                    <span class="text-[12px] text-brand-dark/35 z-10">[ sin foto ]</span>
                                @endunless
                            </div>

                            {{-- Info --}}
                            <div class="p-6 lg:p-8 flex flex-col">
                                @if ($ad->locationLabel())
                                    <p class="text-[11px] text-brand-sage font-medium tracking-[1.5px] mb-2">{{ strtoupper($ad->locationLabel()) }} —</p>
                                @endif
                                <h3 class="font-serif text-[26px] leading-tight tracking-tight mb-3">{{ $ad->title }}</h3>
                                @if ($ad->description)
                                    <p class="text-[14px] text-brand-text leading-relaxed mb-4 line-clamp-4">{{ $ad->description }}</p>
                                @endif

                                @if (count($tags) > 0)
                                    <div class="flex flex-wrap gap-2 mb-5">
                                        @foreach ($tags as $tag)
                                            <span class="px-3 py-1.5 rounded-full border border-brand-dark/10 text-[12px] text-brand-text">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="border-t border-brand-dark/5 pt-4 mt-auto flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        @if ($ad->user->avatarUrl())
                                            <img src="{{ $ad->user->avatarUrl() }}" alt="{{ $ad->user->name }}" class="w-9 h-9 rounded-full object-cover">
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[11px] font-semibold flex items-center justify-center">{{ $ad->user->initials() }}</div>
                                        @endif
                                        <div>
                                            <p class="text-[14px] font-medium leading-tight">{{ $ad->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-serif text-[22px] font-medium leading-none">{{ $ad->formattedPrice() }}</p>
                                        @if ($ad->priceUnitLabel())
                                            <p class="text-[11px] text-brand-muted mt-1">{{ $ad->priceUnitLabel() }}</p>
                                        @endif
                                    </div>
                                </div>

                                <a href="{{ route('listing', $ad) }}" class="mt-5 inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                                    Ver anuncio
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($ads->hasPages())
                    <div class="mt-8">
                        {{ $ads->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <x-favorite-toggle-script />
</x-public>
