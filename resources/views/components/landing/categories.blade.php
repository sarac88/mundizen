<section class="relative px-9 py-14">

    {{-- Formas flotantes decorativas (todas dentro de los bordes) --}}
    <x-landing.shapes type="circles-sage"
        class="pointer-events-none hidden lg:block absolute top-20 left-40 w-28 h-28 z-0 animate-[float-slow_11s_ease-in-out_infinite]" />
    <x-landing.shapes type="dots-sand"
        class="pointer-events-none hidden md:block absolute top-4 right-60 w-20 h-20 z-0" />
    <x-landing.shapes type="leaf-sage"
        class="pointer-events-none hidden lg:block absolute bottom-4 right-19 w-28 h-28 z-0 animate-[float_9s_ease-in-out_infinite]" />
    <div class="max-w-7xl mx-auto">
        {{-- Encabezado --}}
        <div class="relative z-10 text-center mb-10">
            <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2.5">— EXPLORA —</p>
            <h2 class="font-serif font-normal text-[32px] tracking-tight">
                Cuatro caminos hacia <span class="italic">tu calma</span>
            </h2>
        </div>

        {{-- Grid de 4 tarjetas --}}
        <div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Manuales --}}
            <a href="#" class="group p-7 px-5 bg-brand-sage-soft rounded-[28px] relative overflow-hidden transition-transform hover:scale-[1.02]">
                <svg class="absolute -top-5 -right-5 w-20 h-20 opacity-40" viewBox="0 0 100 100" aria-hidden="true">
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#7BA888" stroke-width="1"/>
                    <circle cx="50" cy="50" r="25" fill="none" stroke="#7BA888" stroke-width="1"/>
                </svg>
                <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center mb-4 relative">
                    <flux:icon.hand class="w-5 h-5 text-brand-sage-dark" />
                </div>
                <p class="text-[15px] font-medium mb-1.5 relative">Manuales</p>
                <p class="text-xs text-brand-text leading-relaxed relative">Masaje, quiromasaje, reflexología</p>
                <p class="text-[11px] text-brand-sage-dark font-medium mt-3 relative">682 terapeutas →</p>
            </a>

            {{-- Energéticas --}}
            <a href="#" class="group p-7 px-5 bg-brand-sand rounded-[28px] relative overflow-hidden transition-transform hover:scale-[1.02]">
                <svg class="absolute -top-5 -right-5 w-20 h-20 opacity-40" viewBox="0 0 100 100" aria-hidden="true">
                    <path d="M50 10 Q 80 30 70 60 Q 50 90 30 60 Q 20 30 50 10 Z" fill="none" stroke="#C9A876" stroke-width="1"/>
                </svg>
                <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center mb-4 relative">
                    <flux:icon.sparkles class="w-5 h-5 text-brand-sand-dark" />
                </div>
                <p class="text-[15px] font-medium mb-1.5 relative">Energéticas</p>
                <p class="text-xs text-brand-text leading-relaxed relative">Reiki, chakras, biomagnetismo</p>
                <p class="text-[11px] text-brand-sand-dark font-medium mt-3 relative">438 terapeutas →</p>
            </a>

            {{-- Cursos --}}
            <a href="#" class="group p-7 px-5 bg-brand-sky rounded-[28px] relative overflow-hidden transition-transform hover:scale-[1.02]">
                <svg class="absolute -top-5 -right-5 w-20 h-20 opacity-40" viewBox="0 0 100 100" aria-hidden="true">
                    <rect x="20" y="20" width="60" height="60" rx="20" fill="none" stroke="#7A9499" stroke-width="1" transform="rotate(15 50 50)"/>
                </svg>
                <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center mb-4 relative">
                    <flux:icon.graduation-cap class="w-5 h-5 text-brand-sky-dark" />
                </div>
                <p class="text-[15px] font-medium mb-1.5 relative">Cursos</p>
                <p class="text-xs text-brand-text leading-relaxed relative">Talleres y formación online</p>
                <p class="text-[11px] text-brand-sky-dark font-medium mt-3 relative">126 disponibles →</p>
            </a>

            {{-- Productos --}}
            <a href="#" class="group p-7 px-5 bg-brand-coral rounded-[28px] relative overflow-hidden transition-transform hover:scale-[1.02]">
                <svg class="absolute -top-5 -right-5 w-20 h-20 opacity-40" viewBox="0 0 100 100" aria-hidden="true">
                    <path d="M30 50 Q 50 20 70 50 Q 50 80 30 50 Z" fill="none" stroke="#B88478" stroke-width="1"/>
                </svg>
                <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center mb-4 relative">
                    <flux:icon.droplet class="w-5 h-5 text-brand-coral-dark" />
                </div>
                <p class="text-[15px] font-medium mb-1.5 relative">Productos</p>
                <p class="text-xs text-brand-text leading-relaxed relative">Aceites, cosmética natural</p>
                <p class="text-[11px] text-brand-coral-dark font-medium mt-3 relative">+800 productos →</p>
            </a>

        </div>
    </div>
</section>