<section class="relative px-4 py-8 md:px-6 md:py-10 lg:px-9 lg:py-16">

    {{-- Formas decorativas exteriores (alrededor de la caja oscura) --}}
    <x-landing.shapes type="blob-sky"
        class="pointer-events-none hidden lg:block absolute -top-15 -left-12 w-56 h-56 z-0 animate-[float-drift_5s_ease-in-out_infinite]" />
    <x-landing.shapes type="wave-sage"
        class="pointer-events-none hidden md:block absolute top-20 right-24 w-36 h-20 z-0" />
    <x-landing.shapes type="dots-sand"
        class="pointer-events-none hidden md:block absolute bottom-25 left-20 w-25 h-25 z-0 animate-float" />
    <x-landing.shapes type="drop-coral"
        class="pointer-events-none hidden lg:block absolute bottom-40 right-10 w-30 h-30 z-0 animate-[float-tilt_9s_ease-in-out_infinite]" />

    <div class="max-w-7xl mx-auto relative">

        <div class="relative bg-brand-dark rounded-2xl lg:rounded-[32px] p-6 sm:p-8 lg:p-12 grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 items-center overflow-hidden">

            {{-- Logo gigante decorativo al fondo --}}
            <img src="/images/logo.svg"
                 alt=""
                 aria-hidden="true"
                 class="absolute -bottom-20 -right-20 w-80 h-80 opacity-[0.12] pointer-events-none">

            {{-- Círculos concéntricos sutiles arriba a la izquierda dentro de la caja --}}
            <svg class="absolute -top-10 -left-10 w-40 h-40 opacity-[0.08] pointer-events-none" viewBox="0 0 100 100" aria-hidden="true">
                <circle cx="50" cy="50" r="45" fill="none" stroke="#acd781" stroke-width="0.6"/>
                <circle cx="50" cy="50" r="32" fill="none" stroke="#acd781" stroke-width="0.6"/>
                <circle cx="50" cy="50" r="18" fill="none" stroke="#acd781" stroke-width="0.6"/>
            </svg>

            {{-- Columna izquierda: texto + CTAs --}}
            <div class="relative z-10">
                <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-3">— PARA TERAPEUTAS —</p>

                <h2 class="font-serif font-normal text-2xl sm:text-3xl lg:text-[36px] text-brand-cream leading-[1.1] tracking-tight mb-4">
                    Comparte tu don con <span class="italic text-brand-lime-soft">quien lo necesita.</span>
                </h2>

                <p class="text-sm text-white/70 leading-relaxed max-w-sm mb-7">
                    Publica gratis, gana visibilidad y construye una comunidad alrededor de tu práctica. Sin comisiones, sin complicaciones.
                </p>

                <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                    <a href="{{ route('register') }}"
                       class="bg-brand-cream text-brand-dark px-6 py-3.5 rounded-full text-[13px] font-medium hover:opacity-90 transition">
                        Publicar anuncio
                    </a>
                    <a href="#"
                       class="bg-transparent text-brand-cream border border-white/25 px-6 py-3.5 rounded-full text-[13px] font-medium hover:bg-white/5 transition">
                        Ver cómo funciona
                    </a>
                </div>
            </div>

            {{-- Columna derecha: imagen en forma orgánica --}}
            <div class="hidden lg:block lg:relative lg:z-10 lg:h-80">
                <div class="absolute inset-0 bg-cover bg-center"
                     style="clip-path: path('M 240 10 C 360 0, 440 80, 430 200 C 420 310, 320 360, 210 350 C 90 340, 20 240, 40 130 C 60 30, 150 20, 240 10 Z'); background-image: url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80');">
                </div>
            </div>

        </div>
    </div>
</section>