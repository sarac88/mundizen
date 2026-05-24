<footer class="relative bg-brand-dark px-4 pt-7 pb-6 md:px-6 md:pt-8 md:pb-7 lg:px-9 lg:pt-10 lg:pb-8 overflow-hidden">

    {{-- Formas decorativas sutiles (corner-aligned → corte natural en esquina) --}}
    <x-landing.shapes type="blob-sage"
        class="pointer-events-none hidden md:block absolute -top-16 -left-12 w-48 h-48 z-0 opacity-[0.08] animate-[float_12s_ease-in-out_infinite]" />
    <x-landing.shapes type="blob-sand"
        class="pointer-events-none hidden md:block absolute -bottom-16 -right-12 w-52 h-52 z-0 opacity-[0.07] animate-[float-slow_14s_ease-in-out_infinite]" />
    <x-landing.shapes type="dots-cream"
        class="pointer-events-none hidden md:block absolute top-6 right-1/3 w-20 h-20 z-0" />

    <div class="relative z-10 max-w-7xl mx-auto">

        {{-- Línea superior: logo + enlaces --}}
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-5">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2">
				<img src="/images/logo.svg" alt="Mundizen" class="h-7 w-auto">
				<span class="font-display text-[20px] font-semibold tracking-tight">
					<span class="text-brand-cream">mundi</span><span class="text-brand-sage">zen</span>
				</span>
			</a>

            {{-- Enlaces legales + contacto --}}
            <div class="flex flex-wrap gap-5 text-[11px] text-white/50">
                <a href="#" class="hover:text-brand-cream transition">Condiciones</a>
                <a href="#" class="hover:text-brand-cream transition">Privacidad</a>
                <a href="#" class="hover:text-brand-cream transition">Cookies</a>
                <a href="tel:+34657643234" class="hover:text-brand-cream transition">657 643 234</a>
            </div>
        </div>

        {{-- Tagline centrado --}}
        <p class="text-[10px] text-white/40 text-center tracking-[1px]">
            — TU ESPACIO DE TERAPIAS NATURALES —
        </p>
    </div>
</footer>