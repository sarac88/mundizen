<x-public :title="$ad->title">

    @php
        $stripes = 'background-image: repeating-linear-gradient(45deg, transparent, transparent 9px, rgba(42,61,54,0.05) 9px, rgba(42,61,54,0.05) 10px);';

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

        $categoryName = $ad->categoryLabel();
        $tags = $ad->certifications ?? [];
        $certs = $ad->certifications ?? [];
        $mainPhoto = $ad->photos->first();
        $publishedAdsCount = $ad->user->ads()->where('status', 'published')->count();

        $weekdayMap = [
            'L' => 'LUN',
            'M' => 'MAR',
            'X' => 'MIÉ',
            'J' => 'JUE',
            'V' => 'VIE',
            'S' => 'SÁB',
            'D' => 'DOM',
        ];
        $availability = $ad->availability ?? [];
    @endphp

    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-9 py-6">

        {{-- Breadcrumb + navegación --}}
        <div class="flex items-center justify-between mb-6">
            <nav class="flex items-center gap-2 text-[13px] text-brand-muted flex-wrap">
                <span>mundizen</span>
                <span>/</span>
                @if ($ad->city)
                    <a href="{{ route('search', ['city' => $ad->city]) }}" class="text-brand-sage hover:underline">{{ $ad->city }}</a>
                    <span>/</span>
                @endif
                @if ($ad->category)
                    <a href="{{ route('search', ['category' => $ad->category]) }}" class="text-brand-sage hover:underline">{{ strtolower($categoryName) }}</a>
                    <span>/</span>
                @endif
                <span class="text-brand-dark">{{ Str::limit($ad->title, 40) }}</span>
            </nav>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('search') }}" class="w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition" aria-label="Volver a buscar">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
            </div>
        </div>

        {{-- ===== Grid principal ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">

            {{-- ===== Columna izquierda ===== --}}
            <div>
                {{-- Galería --}}
                <div class="relative rounded-2xl overflow-hidden min-h-[420px] bg-brand-cream border border-brand-dark/5 flex items-center justify-center" style="{{ $stripes }}">
                    @if ($mainPhoto)
                        <img src="{{ $mainPhoto->url }}" alt="{{ $ad->title }}" id="main-photo" class="absolute inset-0 w-full h-full object-cover">
                    @endif

                    <div class="absolute top-4 left-4 flex items-center gap-2 z-10">
                        @if ($categoryName)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $catColor[$categoryName] ?? 'bg-brand-sage-soft text-brand-sage-dark' }} text-[12px] font-medium">
                                <x-lucide :name="$catIcon[$categoryName] ?? 'hand'" class="w-3.5 h-3.5" /> {{ $categoryName }}
                            </span>
                        @endif
                        @if ($ad->isVerified())
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-brand-dark text-brand-cream text-[12px] font-medium">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                Verificado
                            </span>
                        @endif
                    </div>
                    <x-favorite-button :ad="$ad" :favorited="$isFavorited" class="absolute top-4 right-4 z-10" />
                    @unless ($mainPhoto)
                        <span class="text-[12px] text-brand-dark/35 z-10">[ sin foto ]</span>
                    @endunless
                    @if ($ad->photos->count() > 0)
                        <span class="absolute bottom-4 right-4 z-10 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-brand-dark text-brand-cream text-[12px] font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z" /></svg>
                            {{ $ad->photos->count() }} {{ $ad->photos->count() === 1 ? 'foto' : 'fotos' }}
                        </span>
                    @endif
                </div>

                {{-- Miniaturas --}}
                @if ($ad->photos->count() > 1)
                    <div class="grid grid-cols-4 gap-3 mt-3">
                        @foreach ($ad->photos as $i => $photo)
                            <button type="button" data-photo-thumb data-url="{{ $photo->url }}" @class([
                                'h-24 rounded-xl overflow-hidden transition',
                                'ring-2 ring-brand-dark' => $i === 0,
                                'border border-brand-dark/5 hover:ring-2 hover:ring-brand-dark/20' => $i !== 0,
                            ])>
                                <img src="{{ $photo->url }}" alt="Foto {{ $i + 1 }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Título --}}
                <div class="mt-7">
                    @if ($categoryName)
                        <p class="text-[11px] text-brand-sage font-medium tracking-[1.5px] mb-2">{{ strtoupper($categoryName) }}</p>
                    @endif
                    <h1 class="font-serif font-normal text-[34px] lg:text-[40px] leading-tight tracking-tight mb-4">{{ $ad->title }}</h1>

                    <div class="flex items-center flex-wrap gap-x-4 gap-y-2 text-[13px] text-brand-text">
                        @if ($ad->city || $ad->address)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                {{ collect([$ad->city, $ad->address])->filter()->implode(' · ') }}
                            </span>
                        @endif
                        @if ($ad->mode)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                                {{ $ad->modeLabel() }}
                            </span>
                        @endif
                        @if ($ad->duration)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $ad->duration }} min
                            </span>
                        @endif
                        <span class="text-brand-muted">· publicado {{ $ad->created_at->diffForHumans() }}</span>
                    </div>

                    <p class="mt-6 font-serif text-brand-sage-dark">
                        <span class="text-[40px] font-medium">{{ $ad->formattedPrice() }}</span>
                        @if ($ad->priceUnitLabel())
                            <span class="text-[15px] text-brand-text">{{ $ad->priceUnitLabel() }}</span>
                        @endif
                    </p>
                </div>

                {{-- Oferta de servicio --}}
                @if ($ad->description)
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Oferta de servicio</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="space-y-4 text-[15px] text-brand-text leading-relaxed">
                        {!! nl2br(e($ad->description)) !!}
                    </div>
                @endif

                @if (count($tags) > 0)
                    <div class="flex flex-wrap gap-2 mt-5">
                        @foreach ($tags as $tag)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-brand-dark/10 text-[13px] text-brand-text">
                                <svg class="w-3.5 h-3.5 text-brand-sage-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Sobre el autor --}}
                <div class="flex items-center gap-4 mt-10 mb-5">
                    <h2 class="font-serif text-[24px] tracking-tight">Sobre {{ $ad->user->name }}</h2>
                    <div class="flex-1 h-px bg-brand-dark/10"></div>
                </div>
                <div class="flex items-start gap-4">
                    @if ($ad->user->avatarUrl())
                        <img src="{{ $ad->user->avatarUrl() }}" alt="{{ $ad->user->name }}" class="shrink-0 w-16 h-16 aspect-square rounded-full object-cover">
                    @else
                        <div class="shrink-0 w-16 h-16 aspect-square rounded-full bg-brand-sage-soft text-brand-sage-dark text-[16px] font-semibold flex items-center justify-center">{{ $ad->user->initials() }}</div>
                    @endif
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <p class="text-[17px] font-medium">{{ $ad->user->name }}</p>
                            @if ($ad->isVerified())
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-brand-sage/15 text-brand-sage-dark text-[11px] font-medium">
                                    <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    Verificado
                                </span>
                            @endif
                        </div>
                        @if ($ad->user->city ?? $ad->city)
                            <p class="text-[13px] text-brand-muted mt-1">{{ $ad->user->city ?? $ad->city }}</p>
                        @endif
                        @if ($ad->user->bio)
                            <p class="text-[14px] text-brand-text leading-relaxed mt-3">{{ $ad->user->bio }}</p>
                        @endif
                        @if (count($certs) > 0)
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach ($certs as $cert)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-brand-dark/10 text-[13px] text-brand-text">
                                        <svg class="w-3.5 h-3.5 text-brand-sage-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="9" r="5" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 13.4L7.5 21l4.5-2.6 4.5 2.6-1.5-7.6" /></svg>
                                        {{ $cert }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Disponibilidad --}}
                @if (count($availability) > 0)
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Disponibilidad semanal</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-7 gap-2.5">
                        @foreach ($weekdayMap as $code => $label)
                            @php $active = in_array($code, $availability, true); @endphp
                            <div @class([
                                'rounded-xl p-3 text-center',
                                'bg-white border border-brand-dark/8' => $active,
                                'bg-brand-cream/50 border border-transparent' => ! $active,
                            ])>
                                <p class="text-[10px] tracking-wide text-brand-muted">{{ $label }}</p>
                                @if ($active)
                                    <p class="font-serif text-[22px] mt-0.5 text-brand-sage-dark">✓</p>
                                    <p class="text-[11px] text-brand-sage-dark mt-1">Disponible</p>
                                @else
                                    <p class="text-brand-muted mt-2">—</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <p class="text-[12px] text-brand-muted mt-3">Próximamente podrás ver franjas horarias por día.</p>
                @endif

                {{-- Lugar --}}
                @if ($ad->city || $ad->address)
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Lugar</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="rounded-2xl overflow-hidden border border-brand-dark/5 grid grid-cols-1 sm:grid-cols-[1fr_1.2fr] bg-[#EFEDE6]">
                        <div class="min-h-[200px] bg-brand-cream flex items-center justify-center text-[12px] text-brand-dark/35" style="{{ $stripes }}">[ mapa · zona aproximada ]</div>
                        <div class="p-6">
                            <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-2">DIRECCIÓN</p>
                            @if ($ad->address)
                                <p class="font-serif text-[22px] tracking-tight">{{ $ad->address }}</p>
                            @endif
                            @if ($ad->city)
                                <p class="text-[14px] text-brand-text mt-0.5">{{ $ad->city }}</p>
                            @endif
                            <p class="text-[13px] text-brand-muted leading-relaxed mt-3">Por privacidad, la dirección exacta se comparte cuando confirmas la sesión.</p>
                        </div>
                    </div>
                @endif

                {{-- Formulario de contacto --}}
                <div id="contacto" class="flex items-center gap-4 mt-10 mb-5">
                    <h2 class="font-serif text-[24px] tracking-tight">¿Te interesa esta oferta? Escríbele un mensaje</h2>
                    <div class="flex-1 h-px bg-brand-dark/10"></div>
                </div>
                @php
                    $field = 'w-full px-4 py-3 rounded-xl border border-brand-dark/10 bg-white text-[14px] text-brand-dark placeholder:text-brand-muted focus:outline-none focus:border-brand-dark/25';
                    $flabel = 'block text-[13px] font-medium mb-2';
                @endphp
                <form class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="{{ $flabel }}">Nombre <span class="text-red-400">*</span></label>
                            <input type="text" placeholder="Tu nombre" class="{{ $field }}">
                        </div>
                        <div>
                            <label class="{{ $flabel }}">Email <span class="text-red-400">*</span></label>
                            <input type="email" placeholder="tu@email.com" class="{{ $field }}">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="{{ $flabel }}">Asunto <span class="text-red-400">*</span></label>
                            <input type="text" value="Me interesa: {{ $ad->title }}" class="{{ $field }}">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="{{ $flabel }}">Mensaje <span class="text-red-400">*</span></label>
                            <textarea rows="4" placeholder="Hola, me interesa esta oferta..." class="{{ $field }} resize-none"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <p class="text-[12px] text-brand-muted"><span class="text-red-400">*</span> campos obligatorios</p>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                            Enviar mensaje
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                        </button>
                    </div>
                </form>

                {{-- Más en categoría --}}
                @if ($related->isNotEmpty())
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Más en {{ strtolower($categoryName) }}</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($related as $rel)
                            <a href="{{ route('listing', $rel) }}" class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] overflow-hidden block hover:shadow-[0_12px_40px_rgba(42,61,54,0.08)] transition">
                                <div class="h-32 bg-brand-sage-soft flex items-center justify-center overflow-hidden" style="{{ $stripes }}">
                                    @if ($rel->mainPhoto)
                                        <img src="{{ $rel->mainPhoto->url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-[11px] text-brand-dark/35">[ sin foto ]</span>
                                    @endif
                                </div>
                                <div class="p-5">
                                    @if ($rel->locationLabel())
                                        <p class="text-[12px] text-brand-muted mb-1">{{ $rel->locationLabel() }}</p>
                                    @endif
                                    <h3 class="font-serif text-[17px] leading-snug tracking-tight mb-3">{{ $rel->title }}</h3>
                                    <div class="flex items-end justify-between">
                                        <p>
                                            <span class="font-serif text-[18px] font-medium">{{ $rel->formattedPrice() }}</span>
                                            @if ($rel->priceUnitLabel())
                                                <span class="text-[12px] text-brand-muted">{{ $rel->priceUnitLabel() }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ===== Columna derecha (sidebar) ===== --}}
            <aside class="flex flex-col gap-5 lg:sticky lg:top-24">

                {{-- Tarjeta del profesional --}}
                <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.05)] p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3 min-w-0 flex-1">
                            @if ($ad->user->avatarUrl())
                                <img src="{{ $ad->user->avatarUrl() }}" alt="{{ $ad->user->name }}" class="shrink-0 w-12 h-12 aspect-square rounded-full object-cover">
                            @else
                                <div class="shrink-0 w-12 h-12 aspect-square rounded-full bg-brand-sage-soft text-brand-sage-dark text-[14px] font-semibold flex items-center justify-center">{{ $ad->user->initials() }}</div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-[16px] font-medium leading-tight">{{ $ad->user->name }}</p>
                                @if ($ad->user->bio)
                                    <p class="text-[12px] text-brand-muted leading-snug mt-1 line-clamp-2">{{ $ad->user->bio }}</p>
                                @endif
                            </div>
                        </div>
                        <x-favorite-button :ad="$ad" :favorited="$isFavorited" variant="sidebar" />
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-center border-t border-b border-brand-dark/5 my-5 py-4">
                        <div>
                            <p class="font-serif text-[20px] font-medium">{{ $ad->photos->count() }}</p>
                            <p class="text-[11px] text-brand-muted mt-0.5">{{ $ad->photos->count() === 1 ? 'foto' : 'fotos' }}</p>
                        </div>
                        <div>
                            <p class="font-serif text-[20px] font-medium">{{ str_pad((string) $publishedAdsCount, 2, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-[11px] text-brand-muted mt-0.5">anuncios</p>
                        </div>
                    </div>

                    @if ($ad->city || $ad->address)
                        <p class="text-[13px] text-brand-text flex items-center gap-1.5 mb-4">
                            <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            {{ collect([$ad->city, $ad->address])->filter()->implode(', ') }}
                        </p>
                    @endif

                    <a href="#contacto" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
                        Escribir mensaje
                    </a>
                </div>

                {{-- Compártelo --}}
                <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-6">
                    <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-4">COMPÁRTELO</p>
                    <div class="flex items-center gap-2.5">
                        <button class="flex-1 h-10 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark hover:bg-brand-sage-soft/30 transition" aria-label="Copiar enlace">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" /></svg>
                        </button>
                        <button class="flex-1 h-10 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark hover:bg-brand-sage-soft/30 transition" aria-label="Compartir en X">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.66l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" /></svg>
                        </button>
                        <button class="flex-1 h-10 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark hover:bg-brand-sage-soft/30 transition" aria-label="Compartir por WhatsApp">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                        </button>
                        <button class="flex-1 h-10 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark hover:bg-brand-sage-soft/30 transition" aria-label="Compartir por email">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                        </button>
                    </div>
                </div>

                {{-- Denunciar --}}
                <a href="#" class="flex items-center justify-center gap-2 px-5 py-3.5 rounded-2xl bg-red-50 text-[13px] font-medium text-red-500/90 hover:text-red-600 hover:bg-red-100/60 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Denunciar este anuncio
                </a>
            </aside>
        </div>
    </div>

    @if ($ad->photos->count() > 1)
        <script>
            document.querySelectorAll('[data-photo-thumb]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const main = document.getElementById('main-photo');
                    if (main) main.src = btn.dataset.url;
                    document.querySelectorAll('[data-photo-thumb]').forEach(t => {
                        t.classList.remove('ring-2', 'ring-brand-dark');
                        t.classList.add('border', 'border-brand-dark/5');
                    });
                    btn.classList.add('ring-2', 'ring-brand-dark');
                    btn.classList.remove('border', 'border-brand-dark/5');
                });
            });
        </script>
    @endif

    <x-favorite-toggle-script />
</x-public>
