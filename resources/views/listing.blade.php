<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Masaje sueco de 60 min · {{ config('app.name', 'Mundizen') }}</title>

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
            $stripes = 'background-image: repeating-linear-gradient(45deg, transparent, transparent 9px, rgba(42,61,54,0.05) 9px, rgba(42,61,54,0.05) 10px);';

            $tags = ['Aceite de almendra', 'Cabina privada', 'Camilla térmica'];
            $certs = ['Quiromasaje (CGS)', 'Aromaterapia clínica', 'Reiki nivel II'];
            $thumbs = ['foto 1', 'foto 2', 'foto 3', 'foto 4'];

            $days = [
                ['day' => 'LUN', 'date' => '26', 'slots' => ['10:00', '18:30']],
                ['day' => 'MAR', 'date' => '27', 'slots' => ['12:00', '17:00', '19:30']],
                ['day' => 'MIÉ', 'date' => '28', 'slots' => []],
                ['day' => 'JUE', 'date' => '29', 'slots' => ['11:00', '20:00']],
                ['day' => 'VIE', 'date' => '30', 'slots' => ['10:00', '16:00', '18:30']],
                ['day' => 'SÁB', 'date' => '31', 'slots' => ['11:00']],
                ['day' => 'DOM', 'date' => '01', 'slots' => []],
            ];

            $related = [
                ['photo' => 'reflexología podal', 'location' => 'Madrid · A domicilio', 'title' => 'Reflexología podal a domicilio', 'price' => '55 €', 'unit' => '/ sesión', 'rating' => '4.7', 'bg' => 'bg-brand-sage-soft'],
                ['photo' => 'masaje deportivo',   'location' => 'Valencia · Presencial', 'title' => 'Quiromasaje deportivo — recuperación post-entreno', 'price' => '50 €', 'unit' => '/ sesión', 'rating' => '4.9', 'bg' => 'bg-brand-sand'],
            ];
        @endphp

        <x-landing.nav />

        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-9 py-6">

            {{-- Breadcrumb + navegación --}}
            <div class="flex items-center justify-between mb-6">
                <nav class="flex items-center gap-2 text-[13px] text-brand-muted flex-wrap">
                    <span>mundizen</span>
                    <span>/</span>
                    <a href="{{ route('search') }}" class="text-brand-sage hover:underline">Valencia</a>
                    <span>/</span>
                    <a href="{{ route('search') }}" class="text-brand-sage hover:underline">manuales</a>
                    <span>/</span>
                    <span class="text-brand-dark">masaje sueco</span>
                </nav>
                <div class="flex items-center gap-2 shrink-0">
                    <button class="w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition" aria-label="Anterior">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    </button>
                    <button class="w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition" aria-label="Siguiente">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                </div>
            </div>

            {{-- ===== Grid principal ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">

                {{-- ===== Columna izquierda ===== --}}
                <div>
                    {{-- Galería --}}
                    <div class="relative rounded-2xl overflow-hidden min-h-[420px] bg-brand-cream border border-brand-dark/5 flex items-center justify-center" style="{{ $stripes }}">
                        <div class="absolute top-4 left-4 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[12px] font-medium">✋ Manuales</span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-brand-dark text-brand-cream text-[12px] font-medium">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                Verificado
                            </span>
                        </div>
                        <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-brand-text hover:text-brand-dark transition" aria-label="Guardar">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                        </button>
                        <span class="text-[12px] text-brand-dark/35">[ foto principal · masaje sueco ]</span>
                        <span class="absolute bottom-4 right-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-brand-dark text-brand-cream text-[12px] font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z" /></svg>
                            4 fotos
                        </span>
                    </div>

                    {{-- Miniaturas --}}
                    <div class="grid grid-cols-4 gap-3 mt-3">
                        @foreach ($thumbs as $i => $thumb)
                            <button @class([
                                'h-24 rounded-xl bg-brand-cream flex items-center justify-center text-[11px] text-brand-dark/35 transition',
                                'ring-2 ring-brand-dark' => $i === 0,
                                'border border-brand-dark/5 hover:ring-2 hover:ring-brand-dark/20' => $i !== 0,
                            ]) style="{{ $stripes }}">{{ $thumb }}</button>
                        @endforeach
                    </div>

                    {{-- Título --}}
                    <div class="mt-7">
                        <p class="text-[11px] text-brand-sage font-medium tracking-[1.5px] mb-2">MANUALES · MASAJE SUECO</p>
                        <h1 class="font-serif font-normal text-[34px] lg:text-[40px] leading-tight tracking-tight mb-4">Masaje sueco de 60 min en estudio céntrico</h1>

                        <div class="flex items-center flex-wrap gap-x-4 gap-y-2 text-[13px] text-brand-text">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                Valencia · Ruzafa
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                                Presencial
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                60 min
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-sage-dark" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.5a.56.56 0 011.04 0l2.12 5.11a.56.56 0 00.48.35l5.52.44c.5.04.7.66.32.99l-4.2 3.6a.56.56 0 00-.18.56l1.28 5.39a.56.56 0 01-.84.6l-4.72-2.88a.56.56 0 00-.6 0l-4.72 2.88a.56.56 0 01-.84-.6l1.28-5.39a.56.56 0 00-.18-.56l-4.2-3.6a.56.56 0 01.32-.99l5.52-.44a.56.56 0 00.48-.35L11.48 3.5z" /></svg>
                                <span class="font-medium text-brand-dark">4.9</span> · 87 reseñas
                            </span>
                            <span class="text-brand-muted">· visto 247 veces · publicado hace 12 días</span>
                        </div>

                        <p class="mt-6 font-serif text-brand-sage-dark">
                            <span class="text-[40px] font-medium">45 €</span>
                            <span class="text-[15px] text-brand-text">/ sesión</span>
                        </p>
                    </div>

                    {{-- Oferta de servicio --}}
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Oferta de servicio</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="space-y-4 text-[15px] text-brand-text leading-relaxed">
                        <p>Sesión clásica de descontracturación con técnica sueca, presión media a profunda. Ideal para acumulación de tensión cervical, lumbar y dorsal.</p>
                        <p>La sesión empieza con una breve charla para identificar zonas a trabajar y termina con unos minutos de relajación e infusión. Materiales incluidos: aceite tibio, camilla térmica, música ambient y aromas suaves.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-5">
                        @foreach ($tags as $tag)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-brand-dark/10 text-[13px] text-brand-text">
                                <svg class="w-3.5 h-3.5 text-brand-sage-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>

                    {{-- Sobre Marta --}}
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Sobre Marta Llorente</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="shrink-0 w-16 h-16 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[16px] font-semibold flex items-center justify-center">ML</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <p class="text-[17px] font-medium">Marta Llorente</p>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-brand-sage/15 text-brand-sage-dark text-[11px] font-medium">
                                    <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    Verificado
                                </span>
                            </div>
                            <p class="text-[13px] text-brand-muted mt-1">8 años de experiencia · Valencia · responde en menos de 2h</p>
                            <p class="text-[15px] text-brand-text leading-relaxed mt-3">Me formé en quiromasaje terapéutico hace casi una década y desde entonces no he parado de aprender técnicas complementarias. Creo en sesiones honestas, sin promesas mágicas, donde el cuerpo encuentra su propio ritmo. Bienvenida a un rato para ti.</p>
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach ($certs as $cert)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-brand-dark/10 text-[13px] text-brand-text">
                                        <svg class="w-3.5 h-3.5 text-brand-sage-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="9" r="5" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 13.4L7.5 21l4.5-2.6 4.5 2.6-1.5-7.6" /></svg>
                                        {{ $cert }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Disponibilidad --}}
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Disponibilidad esta semana</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-7 gap-2.5">
                        @foreach ($days as $d)
                            @php $empty = count($d['slots']) === 0; @endphp
                            <div @class([
                                'rounded-xl p-3 text-center',
                                'bg-white border border-brand-dark/8' => ! $empty,
                                'bg-brand-cream/50 border border-transparent' => $empty,
                            ])>
                                <p class="text-[10px] tracking-wide text-brand-muted">{{ $d['day'] }}</p>
                                <p class="font-serif text-[22px] mt-0.5 {{ $empty ? 'text-brand-muted' : '' }}">{{ $d['date'] }}</p>
                                @if ($empty)
                                    <p class="text-brand-muted mt-2">—</p>
                                @else
                                    <div class="flex flex-col gap-1.5 mt-2">
                                        @foreach ($d['slots'] as $slot)
                                            <span class="px-2 py-1 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[12px]">{{ $slot }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Lugar --}}
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Lugar</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="rounded-2xl overflow-hidden border border-brand-dark/5 grid grid-cols-1 sm:grid-cols-[1fr_1.2fr] bg-[#EFEDE6]">
                        <div class="min-h-[200px] bg-brand-cream flex items-center justify-center text-[12px] text-brand-dark/35" style="{{ $stripes }}">[ mapa · zona aproximada ]</div>
                        <div class="p-6">
                            <p class="text-[11px] text-brand-muted font-medium tracking-[1.5px] mb-2">DIRECCIÓN</p>
                            <p class="font-serif text-[22px] tracking-tight">Ruzafa</p>
                            <p class="text-[14px] text-brand-text mt-0.5">Valencia</p>
                            <p class="text-[13px] text-brand-muted leading-relaxed mt-3">Por privacidad, la dirección exacta se comparte cuando confirmas la sesión.</p>
                        </div>
                    </div>

                    {{-- Formulario de contacto --}}
                    <div class="flex items-center gap-4 mt-10 mb-5">
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
                                <input type="text" value="Me interesa: Masaje sueco de 60 min en estudio céntrico" class="{{ $field }}">
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

                    {{-- Más en manuales --}}
                    <div class="flex items-center gap-4 mt-10 mb-5">
                        <h2 class="font-serif text-[24px] tracking-tight">Más en manuales</h2>
                        <div class="flex-1 h-px bg-brand-dark/10"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($related as $rel)
                            <a href="{{ route('listing') }}" class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] overflow-hidden block hover:shadow-[0_12px_40px_rgba(42,61,54,0.08)] transition">
                                <div class="h-32 {{ $rel['bg'] }} flex items-center justify-center text-[11px] text-brand-dark/35" style="{{ $stripes }}">[ {{ $rel['photo'] }} ]</div>
                                <div class="p-5">
                                    <p class="text-[12px] text-brand-muted mb-1">{{ $rel['location'] }}</p>
                                    <h3 class="font-serif text-[17px] leading-snug tracking-tight mb-3">{{ $rel['title'] }}</h3>
                                    <div class="flex items-end justify-between">
                                        <p><span class="font-serif text-[18px] font-medium">{{ $rel['price'] }}</span> <span class="text-[12px] text-brand-muted">{{ $rel['unit'] }}</span></p>
                                        <span class="text-[12px] text-brand-text">☆ {{ $rel['rating'] }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ===== Columna derecha (sidebar) ===== --}}
                <aside class="flex flex-col gap-5 lg:sticky lg:top-24">

                    {{-- Tarjeta del profesional --}}
                    <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.05)] p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[14px] font-semibold flex items-center justify-center">ML</div>
                                <div>
                                    <p class="text-[16px] font-medium leading-tight">Marta Llorente</p>
                                    <p class="text-[12px] text-brand-muted mt-0.5">☆ 4.9 · 87 reseñas</p>
                                </div>
                            </div>
                            <button class="w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition" aria-label="Guardar">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-center border-t border-b border-brand-dark/5 my-5 py-4">
                            <div>
                                <p class="font-serif text-[20px] font-medium">4</p>
                                <p class="text-[11px] text-brand-muted mt-0.5">fotos</p>
                            </div>
                            <div>
                                <p class="font-serif text-[20px] font-medium">02</p>
                                <p class="text-[11px] text-brand-muted mt-0.5">anuncios</p>
                            </div>
                            <div>
                                <p class="font-serif text-[20px] font-medium">8 años</p>
                                <p class="text-[11px] text-brand-muted mt-0.5">experiencia</p>
                            </div>
                        </div>

                        <p class="text-[13px] text-brand-text flex items-center gap-1.5 mb-4">
                            <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            Valencia, Ruzafa (02104)
                        </p>

                        <button class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
                            Escribir mensaje
                        </button>

                        <div class="flex items-center justify-between mt-3 px-4 py-3 rounded-xl bg-[#F1EEE7]">
                            <span class="flex items-center gap-2 text-[14px] text-brand-dark">
                                <svg class="w-4 h-4 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                                +34 • • • • • • • •
                            </span>
                            <button class="text-[13px] font-medium text-brand-dark hover:text-brand-sage-dark transition">Ver teléfono</button>
                        </div>
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
    </body>
</html>
