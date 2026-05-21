<section class="relative px-9 pt-6 pb-16">

    {{-- Formas flotantes decorativas (cortes en esquinas → naturales) --}}
    <x-landing.shapes type="blob-sage"
        class="pointer-events-none absolute -top-12 -left-20 w-80 h-80 z-0 animate-[float_8s_ease-in-out_infinite]" />

    <x-landing.shapes type="blob-sand"
        class="pointer-events-none absolute -bottom-16 -right-16 w-64 h-64 z-0 opacity-60 animate-[float-slow_10s_ease-in-out_infinite]" />

    <x-landing.shapes type="circles-sage"
        class="pointer-events-none hidden md:block absolute top-28 left-[48%] w-24 h-24 z-0 animate-[float-drift_11s_ease-in-out_infinite]" />

    <x-landing.shapes type="drop-coral"
        class="pointer-events-none hidden lg:block absolute top-8 right-32 w-20 h-20 z-0 animate-[float-tilt_9s_ease-in-out_infinite]" />

    {{-- Contenido en 2 columnas --}}
    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-[1.1fr_1fr] gap-10 items-center max-w-7xl mx-auto">

        {{-- Columna izquierda: texto --}}
        <div>
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-brand-sage/15 rounded-full text-xs text-brand-sage-dark font-medium mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-sage"></span>
                <span>Tu espacio de terapias naturales</span>
            </div>

            {{-- Titular --}}
            <h1 class="font-serif font-normal text-5xl lg:text-[52px] leading-[1.05] tracking-tight mb-4">
                Tu pausa,<br>
                <span class="italic text-brand-sage">tu equilibrio,</span><br>
                tu lugar.
            </h1>

            {{-- Subtítulo --}}
            <p class="text-[15px] text-brand-text leading-relaxed max-w-sm mb-8">
                Descubre terapeutas, cursos y productos para cuidar de ti. Naturalmente.
            </p>

            {{-- Buscador --}}
            <div class="bg-white p-2.5 rounded-full flex items-center gap-1.5 shadow-[0_8px_32px_rgba(42,61,54,0.08)] max-w-md">
                <div class="flex items-center gap-2 flex-1 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-brand-sage" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                    <span class="text-[13px] text-brand-muted">Masaje, reiki, aromaterapia...</span>
                </div>
                <button class="bg-brand-dark text-brand-cream px-6 py-3 rounded-full text-[13px] font-medium hover:opacity-90 transition flex items-center gap-1.5">
                    Buscar
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

            {{-- Stats --}}
            <div class="flex gap-7 mt-9">
                <div>
                    <p class="font-serif text-2xl font-medium">2.4k+</p>
                    <p class="text-[11px] text-brand-muted tracking-wide mt-0.5">Terapeutas</p>
                </div>
                <div>
                    <p class="font-serif text-2xl font-medium">180</p>
                    <p class="text-[11px] text-brand-muted tracking-wide mt-0.5">Ciudades</p>
                </div>
                <div>
                    <p class="font-serif text-2xl font-medium">4.9 ★</p>
                    <p class="text-[11px] text-brand-muted tracking-wide mt-0.5">Valoración</p>
                </div>
            </div>
        </div>

        {{-- Columna derecha: imagen --}}
        <div class="relative h-[440px]">

            {{-- Patrón de puntos decorativo --}}
            <svg class="absolute top-8 -right-3 z-0" width="80" height="80" aria-hidden="true">
                <g fill="#D4C4A8">
                    @foreach ([6,26,46,66] as $y)
                        @foreach ([6,26,46,66] as $x)
                            <circle cx="{{ $x }}" cy="{{ $y }}" r="2"/>
                        @endforeach
                    @endforeach
                </g>
            </svg>

            {{-- Imagen recortada en forma orgánica --}}
            <div class="absolute inset-0 bg-cover bg-center"
                 style="clip-path: path('M 200 0 C 320 20, 380 120, 360 240 C 340 360, 250 420, 140 400 C 30 380, -20 280, 20 160 C 60 40, 130 -20, 200 0 Z'); background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80');">
            </div>

            {{-- Tarjeta flotante: 100% natural --}}
            <div class="absolute bottom-8 -left-3 bg-white px-4 py-3.5 rounded-2xl shadow-[0_12px_40px_rgba(42,61,54,0.12)] flex items-center gap-3 z-20">
                <div class="w-10 h-10 rounded-full bg-brand-sage-soft flex items-center justify-center">
                    <img src="/images/logo.svg" alt="" class="w-6 h-6">
                </div>
                <div>
                    <p class="text-xs font-medium">100% natural</p>
                    <p class="text-[10px] text-brand-muted">Terapeutas certificados</p>
                </div>
            </div>

            {{-- Tarjeta flotante: sesión próxima --}}
            <div class="absolute top-10 -left-5 bg-white px-4 py-3 rounded-2xl shadow-[0_12px_40px_rgba(42,61,54,0.12)] z-20">
                <p class="text-[11px] text-brand-muted mb-1">Sesión próxima</p>
                <p class="text-[13px] font-medium">Hoy · 18:30</p>
            </div>
        </div>

    </div>
</section>