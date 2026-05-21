<nav class="sticky top-0 z-50 flex items-center justify-between px-4 py-3 md:px-6 md:py-4 bg-brand-cream/75 backdrop-blur-md border-b border-brand-dark/5">
    {{-- Logo --}}
    <a href="/" class="flex items-center gap-2.5">
		<img src="/images/logo.svg" alt="Mundzen" class="h-8 w-auto md:h-10">
		<span class="font-display text-[20px] md:text-[24px] font-semibold tracking-tight leading-none">
			<span class="text-neutral-900">mund</span><span class="text-brand-sage">zen</span>
		</span>
	</a>

    {{-- Menú --}}
    <div class="flex items-center gap-3 md:gap-7 text-[13px] text-brand-text">
        <a href="#" class="hidden md:inline hover:text-brand-dark transition">Terapias</a>
        <a href="#" class="hidden md:inline hover:text-brand-dark transition">Cursos</a>
        <a href="#" class="hidden md:inline hover:text-brand-dark transition">Favoritos</a>

        @auth
            <a href="{{ route('dashboard') }}"
               class="px-[18px] py-[9px] bg-brand-dark text-brand-cream rounded-full font-medium hover:opacity-90 transition">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}"
               class="px-[18px] py-[9px] bg-brand-dark text-brand-cream rounded-full font-medium hover:opacity-90 transition">
                Iniciar sesión
            </a>
        @endauth
    </div>
</nav>