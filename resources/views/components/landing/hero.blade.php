<section class="relative px-4 pt-4 pb-10 md:px-6 md:pt-5 md:pb-12 lg:px-9 lg:pt-6 lg:pb-16">

    {{-- Formas flotantes decorativas (cortes en esquinas → naturales) --}}
    <x-landing.shapes type="blob-sage"
        class="pointer-events-none absolute -top-12 -left-20 w-80 h-80 z-0 animate-[float_8s_ease-in-out_infinite]" />

    <x-landing.shapes type="blob-sand"
        class="pointer-events-none hidden lg:block absolute -bottom-16 -right-16 w-64 h-64 z-0 opacity-60 animate-[float-slow_10s_ease-in-out_infinite]" />

    <x-landing.shapes type="circles-sage"
        class="pointer-events-none hidden md:block absolute top-28 left-[48%] w-24 h-24 z-0 animate-[float-drift_11s_ease-in-out_infinite]" />

    <x-landing.shapes type="drop-coral"
        class="pointer-events-none hidden lg:block absolute top-8 right-32 w-20 h-20 z-0 animate-[float-tilt_9s_ease-in-out_infinite]" />

    {{-- Contenido en 2 columnas --}}
    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-[1.1fr_1fr] gap-6 lg:gap-10 items-center max-w-7xl mx-auto">

        {{-- Columna izquierda: texto --}}
        <div class="text-center lg:text-left">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-brand-sage/15 rounded-full text-xs text-brand-sage-dark font-medium mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-sage"></span>
                <span>Tu espacio de terapias naturales</span>
            </div>

            {{-- Titular --}}
            <h1 class="font-serif font-normal text-3xl sm:text-4xl md:text-[46px] lg:text-[52px] leading-[1.05] tracking-tight mb-4">
                Tu pausa,<br>
                <span class="italic text-brand-sage">tu equilibrio,</span><br>
                tu lugar.
            </h1>

            {{-- Subtítulo --}}
            <p class="text-[15px] text-brand-text leading-relaxed max-w-sm mb-8 mx-auto lg:mx-0">
                Descubre terapeutas, cursos y productos para cuidar de ti. Naturalmente.
            </p>

            {{-- Buscador --}}
            <form action="{{ route('search') }}" method="GET" class="bg-white p-2.5 rounded-full flex items-center gap-1.5 border-2 border-[#c8d5d0] hover:border-brand-sage hover:shadow-[0_0_0_4px_rgba(42,61,54,0.08)] transition-all duration-300 w-full max-w-md mx-auto lg:mx-0">
                <div class="flex items-center gap-2 flex-1 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-brand-sage" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                    <input type="text" name="q" placeholder="Masaje, reiki, aromaterapia..."
                           class="w-full bg-transparent text-[13px] text-brand-text placeholder:text-brand-muted focus:outline-none" />
                </div>
                <button type="submit" class="bg-brand-dark text-brand-cream px-6 py-3 rounded-full text-[13px] font-medium hover:opacity-90 transition flex items-center gap-1.5">
                    Buscar
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            {{-- Stats --}}
            <div class="flex flex-wrap justify-center lg:justify-start items-center gap-x-5 gap-y-3 sm:gap-x-6 mt-7 sm:mt-10">
                <div class="flex items-center gap-2.5">
                    <span class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-sage-soft ring-1 ring-brand-sage/15">
                        <flux:icon.users class="w-[18px] h-[18px] text-brand-sage-dark" />
                    </span>
                    <div class="text-left">
                        <p class="font-serif text-xl font-medium leading-none">2.4k+</p>
                        <p class="text-[10px] text-brand-muted tracking-[1.5px] uppercase mt-1">Terapeutas</p>
                    </div>
                </div>

                <span class="hidden sm:block w-px h-9 bg-gradient-to-b from-transparent via-brand-muted/25 to-transparent" aria-hidden="true"></span>

                <div class="flex items-center gap-2.5">
                    <span class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-sky ring-1 ring-brand-sky-dark/15">
                        <flux:icon.map-pin class="w-[18px] h-[18px] text-brand-sky-dark" />
                    </span>
                    <div class="text-left">
                        <p class="font-serif text-xl font-medium leading-none">180</p>
                        <p class="text-[10px] text-brand-muted tracking-[1.5px] uppercase mt-1">Ciudades</p>
                    </div>
                </div>

                <span class="hidden sm:block w-px h-9 bg-gradient-to-b from-transparent via-brand-muted/25 to-transparent" aria-hidden="true"></span>

                <div class="flex items-center gap-2.5">
                    <span class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-sand ring-1 ring-brand-sand-dark/15">
                        <flux:icon.star class="w-[18px] h-[18px] text-brand-sand-dark" />
                    </span>
                    <div class="text-left">
                        <p class="font-serif text-xl font-medium leading-none">4.9<span class="text-brand-sand-dark">/5</span></p>
                        <p class="text-[10px] text-brand-muted tracking-[1.5px] uppercase mt-1">Valoración</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna derecha: imagen --}}
        <div class="hidden lg:block lg:relative lg:h-[440px]">

            {{-- Imagen recortada en forma orgánica --}}
            <div class="absolute inset-0 bg-cover bg-center"
                 style="border-radius: 58% 42% 62% 38% / 50% 65% 35% 50%; background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80');">
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