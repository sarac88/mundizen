<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Buscar terapias · {{ config('app.name', 'Mundizen') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;1,9..144,400;1,9..144,500&family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-brand-cream text-brand-dark min-h-screen font-sans antialiased">

        @php
            $categories = [
                ['name' => 'Todas',       'emoji' => null, 'active' => true],
                ['name' => 'Manuales',    'emoji' => '✋',  'active' => false],
                ['name' => 'Energéticas', 'emoji' => '✨',  'active' => false],
                ['name' => 'Cursos',      'emoji' => '🎓',  'active' => false],
                ['name' => 'Productos',   'emoji' => '💧',  'active' => false],
            ];

            $catColor = [
                'Manuales'    => 'bg-brand-sage-soft text-brand-sage-dark',
                'Energéticas' => 'bg-brand-sand text-brand-sand-dark',
                'Cursos'      => 'bg-brand-sky text-brand-sky-dark',
                'Productos'   => 'bg-brand-coral text-brand-coral-dark',
            ];
            $catEmoji = ['Manuales' => '✋', 'Energéticas' => '✨', 'Cursos' => '🎓', 'Productos' => '💧'];

            $availability = ['Cualquier momento', 'Hoy', 'Esta semana', 'Este fin de semana'];

            $stripes = 'background-image: repeating-linear-gradient(45deg, transparent, transparent 9px, rgba(42,61,54,0.05) 9px, rgba(42,61,54,0.05) 10px);';

            $results = [
                [
                    'category' => 'Manuales', 'verified' => true,
                    'location' => 'Valencia · Presencial',
                    'title' => 'Masaje sueco de 60 min en estudio céntrico',
                    'description' => 'Sesión clásica de descontracturación con técnica sueca, presión media a profunda. Ideal para acumulación de tensión cervical, lumbar y dorsal.',
                    'tags' => ['Aceite de almendra', 'Cabina privada', 'Camilla térmica'],
                    'initials' => 'ML', 'author' => 'Marta Llorente', 'rating' => '4.9', 'reviews' => '87',
                    'price' => '45 €', 'unit' => '/ sesión', 'photo' => 'masaje sueco',
                ],
                [
                    'category' => 'Energéticas', 'verified' => true,
                    'location' => 'Online · Online',
                    'title' => 'Reiki Usui — limpieza energética online',
                    'description' => 'Tratamiento energético por videollamada. Trabajamos los siete chakras principales con apertura, equilibrio y cierre.',
                    'tags' => ['Nivel III', 'Energía a distancia', 'Grabación incluida'],
                    'initials' => 'IR', 'author' => 'Iván Romero', 'rating' => '4.8', 'reviews' => '64',
                    'price' => '30 €', 'unit' => '/ sesión', 'photo' => 'reiki',
                ],
                [
                    'category' => 'Cursos', 'verified' => false,
                    'location' => 'Barcelona · Presencial',
                    'title' => 'Curso intensivo de mindfulness — 8 semanas',
                    'description' => 'Programa estructurado de reducción de estrés basado en atención plena. Grupos reducidos y material de práctica para casa.',
                    'tags' => ['8 semanas', 'Grupo reducido', 'Certificado'],
                    'initials' => 'LS', 'author' => 'Lucía Sanz', 'rating' => '5.0', 'reviews' => '41',
                    'price' => '280 €', 'unit' => '/ curso completo', 'photo' => 'mindfulness',
                ],
                [
                    'category' => 'Manuales', 'verified' => true,
                    'location' => 'Madrid · A domicilio',
                    'title' => 'Reflexología podal terapéutica a domicilio',
                    'description' => 'Estimulación de puntos reflejos del pie para favorecer la relajación y el descanso. Me desplazo a tu domicilio con todo el material.',
                    'tags' => ['A domicilio', 'Aceites naturales', '50 min'],
                    'initials' => 'DO', 'author' => 'Diego Ortiz', 'rating' => '4.7', 'reviews' => '52',
                    'price' => '55 €', 'unit' => '/ sesión', 'photo' => 'reflexología podal',
                ],
                [
                    'category' => 'Energéticas', 'verified' => false,
                    'location' => 'Sevilla · Presencial',
                    'title' => 'Sesión de biomagnetismo y equilibrio',
                    'description' => 'Aplicación de pares biomagnéticos para reequilibrar el pH del organismo. Primera sesión con valoración personalizada incluida.',
                    'tags' => ['Valoración inicial', 'Imanes calibrados', '75 min'],
                    'initials' => 'NT', 'author' => 'Noa Torres', 'rating' => '4.6', 'reviews' => '29',
                    'price' => '40 €', 'unit' => '/ sesión', 'photo' => 'biomagnetismo',
                ],
                [
                    'category' => 'Productos', 'verified' => true,
                    'location' => 'Online · Online',
                    'title' => 'Kit de aceites esenciales para aromaterapia',
                    'description' => 'Selección de seis aceites esenciales puros para relajación y descanso. Envío a toda España con guía de uso incluida.',
                    'tags' => ['100% natural', 'Envío gratis', '6 aceites'],
                    'initials' => 'CM', 'author' => 'Clara Mata', 'rating' => '4.9', 'reviews' => '118',
                    'price' => '38 €', 'unit' => '/ kit', 'photo' => 'aceites esenciales',
                ],
            ];
        @endphp

        {{-- ===== Barra superior (reutiliza el nav de la landing) ===== --}}
        <x-landing.nav />

        {{-- ===== Cabecera + buscador ===== --}}
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-9 pt-8 pb-6">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">EXPLORA —</p>
                    <h1 class="font-serif font-normal text-4xl lg:text-[44px] tracking-tight">
                        Encuentra tu <span class="italic text-brand-sage">terapia.</span>
                    </h1>
                </div>

                <div class="bg-white p-2 rounded-full flex items-center gap-1.5 shadow-[0_8px_32px_rgba(42,61,54,0.08)] w-full lg:w-[440px]">
                    <div class="flex items-center gap-2 flex-1 px-4">
                        <svg class="w-4 h-4 text-brand-sage" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        <input type="text" placeholder="Buscar masaje, reiki, mindfulness..." class="flex-1 bg-transparent text-[13px] text-brand-dark placeholder:text-brand-muted focus:outline-none">
                    </div>
                    <button class="bg-brand-dark text-brand-cream px-6 py-3 rounded-full text-[13px] font-medium hover:opacity-90 transition flex items-center gap-1.5 shrink-0">
                        Buscar
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== Filtros + resultados ===== --}}
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-9 pb-16 grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-start">

            {{-- ===== Filtros ===== --}}
            <aside class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-5 lg:sticky lg:top-24">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-serif text-[20px] tracking-tight">Filtros</h2>
                    <button class="text-[13px] text-brand-text hover:text-brand-dark transition">Limpiar</button>
                </div>

                {{-- Categoría --}}
                <div>
                    <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">CATEGORÍA</p>
                    <div class="flex flex-col gap-1">
                        @foreach ($categories as $cat)
                            <a href="#" @class([
                                'flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[14px] transition',
                                'bg-brand-dark text-brand-cream font-medium' => $cat['active'],
                                'text-brand-text hover:bg-brand-sage-soft/50' => ! $cat['active'],
                            ])>
                                @if ($cat['active'])
                                    <span class="w-2 h-2 rounded-full bg-brand-sage"></span>
                                @else
                                    <span class="text-[15px] leading-none">{{ $cat['emoji'] }}</span>
                                @endif
                                {{ $cat['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Ciudad --}}
                <div class="border-t border-brand-dark/5 mt-5 pt-5">
                    <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">CIUDAD</p>
                    <div class="relative">
                        <select class="w-full appearance-none px-4 py-3 pr-10 rounded-xl border border-brand-dark/10 bg-transparent text-[14px] text-brand-dark focus:outline-none focus:border-brand-dark/25">
                            <option>Todas las ciudades</option>
                            <option>Valencia</option>
                            <option>Barcelona</option>
                            <option>Madrid</option>
                            <option>Sevilla</option>
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
                        <button class="px-4 py-2 rounded-full bg-brand-dark text-brand-cream text-[13px] font-medium">Todas</button>
                        <button class="px-4 py-2 rounded-full border border-brand-dark/15 text-[13px] text-brand-text hover:bg-brand-sage-soft/40 transition">Presencial</button>
                        <button class="px-4 py-2 rounded-full border border-brand-dark/15 text-[13px] text-brand-text hover:bg-brand-sage-soft/40 transition">Online</button>
                        <button class="px-4 py-2 rounded-full border border-brand-dark/15 text-[13px] text-brand-text hover:bg-brand-sage-soft/40 transition">A domicilio</button>
                    </div>
                </div>

                {{-- Precio --}}
                <div class="border-t border-brand-dark/5 mt-5 pt-5">
                    <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">PRECIO</p>
                    <div class="flex items-center justify-between text-[13px] text-brand-text mb-2">
                        <span>0 €</span>
                        <span>300 €</span>
                    </div>
                    <input type="range" min="0" max="300" value="180" class="w-full accent-brand-dark">
                </div>

                {{-- Disponibilidad --}}
                <div class="border-t border-brand-dark/5 mt-5 pt-5">
                    <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-3">DISPONIBILIDAD</p>
                    <div class="flex flex-col gap-1">
                        @foreach ($availability as $i => $avail)
                            <a href="#" @class([
                                'flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[14px] transition',
                                'bg-brand-dark text-brand-cream font-medium' => $i === 0,
                                'text-brand-text hover:bg-brand-sage-soft/50' => $i !== 0,
                            ])>
                                @if ($i === 0)
                                    <span class="w-2 h-2 rounded-full bg-brand-sage"></span>
                                @else
                                    <span class="w-3.5 h-3.5 rounded-full border border-brand-dark/25"></span>
                                @endif
                                {{ $avail }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            {{-- ===== Resultados ===== --}}
            <div>
                {{-- Barra superior --}}
                <div class="flex items-center justify-between mb-5">
                    <p class="text-[14px] text-brand-text"><span class="font-serif text-[18px] font-medium">{{ count($results) }}</span> resultados</p>

                    {{-- Ordenar (dropdown sin JS) --}}
                    <details class="relative group">
                        <summary class="list-none flex items-center gap-2 px-4 py-2 rounded-full border border-brand-dark/10 text-[13px] text-brand-text cursor-pointer hover:text-brand-dark transition [&::-webkit-details-marker]:hidden">
                            <span>Ordenar por: <span class="text-brand-dark font-medium">Relevancia</span></span>
                            <svg class="w-3.5 h-3.5 transition group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </summary>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl border border-brand-dark/5 shadow-[0_12px_40px_rgba(42,61,54,0.12)] p-1.5 z-30">
                            <a href="#" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] text-brand-dark bg-brand-sage-soft/50">
                                Relevancia
                                <svg class="w-3.5 h-3.5 text-brand-sage-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </a>
                            <a href="#" class="block px-3 py-2 rounded-xl text-[13px] text-brand-text hover:bg-brand-sage-soft/40 transition">Precio ↑</a>
                            <a href="#" class="block px-3 py-2 rounded-xl text-[13px] text-brand-text hover:bg-brand-sage-soft/40 transition">Precio ↓</a>
                            <a href="#" class="block px-3 py-2 rounded-xl text-[13px] text-brand-text hover:bg-brand-sage-soft/40 transition">Mejor valorados</a>
                        </div>
                    </details>
                </div>

                {{-- Tarjetas --}}
                <div class="flex flex-col gap-5">
                    @foreach ($results as $r)
                        <article class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] overflow-hidden grid grid-cols-1 lg:grid-cols-2">

                            {{-- Foto --}}
                            <div class="relative min-h-[300px] lg:min-h-[360px] bg-brand-cream flex items-center justify-center" style="{{ $stripes }}">
                                <div class="absolute top-4 left-4 flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $catColor[$r['category']] }} text-[12px] font-medium">
                                        <span>{{ $catEmoji[$r['category']] }}</span>{{ $r['category'] }}
                                    </span>
                                    @if ($r['verified'])
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-brand-dark text-brand-cream text-[12px] font-medium">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            Verificado
                                        </span>
                                    @endif
                                </div>
                                <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-brand-text hover:text-brand-dark transition" aria-label="Guardar">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                                <span class="text-[12px] text-brand-dark/35">[ {{ $r['photo'] }} ]</span>
                            </div>

                            {{-- Info --}}
                            <div class="p-6 lg:p-8 flex flex-col">
                                <p class="text-[11px] text-brand-sage font-medium tracking-[1.5px] mb-2">{{ strtoupper($r['location']) }} —</p>
                                <h3 class="font-serif text-[26px] leading-tight tracking-tight mb-3">{{ $r['title'] }}</h3>
                                <p class="text-[14px] text-brand-text leading-relaxed mb-4">{{ $r['description'] }}</p>

                                <div class="flex flex-wrap gap-2 mb-5">
                                    @foreach ($r['tags'] as $tag)
                                        <span class="px-3 py-1.5 rounded-full border border-brand-dark/10 text-[12px] text-brand-text">{{ $tag }}</span>
                                    @endforeach
                                </div>

                                <div class="border-t border-brand-dark/5 pt-4 mt-auto flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-9 h-9 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[11px] font-semibold flex items-center justify-center">{{ $r['initials'] }}</div>
                                        <div>
                                            <p class="text-[14px] font-medium leading-tight">{{ $r['author'] }}</p>
                                            <p class="text-[12px] text-brand-muted mt-0.5">☆ {{ $r['rating'] }} · {{ $r['reviews'] }} reseñas</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-serif text-[22px] font-medium leading-none">{{ $r['price'] }}</p>
                                        <p class="text-[11px] text-brand-muted mt-1">{{ $r['unit'] }}</p>
                                    </div>
                                </div>

                                <a href="{{ route('listing') }}" class="mt-5 inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                                    Ver anuncio
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
</html>
