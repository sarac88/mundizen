@php
    $navLink = fn ($routeName) => request()->routeIs($routeName)
        ? 'relative text-brand-dark font-medium'
        : 'hover:text-brand-dark transition';
@endphp

<nav class="sticky top-0 z-50 flex items-center justify-between px-4 py-3 md:px-6 md:py-4 bg-brand-cream/75 backdrop-blur-md border-b border-brand-dark/5">
    {{-- Logo --}}
    <a href="/" class="flex items-center gap-2.5">
		<img src="/images/logo.svg" alt="Mundizen" class="h-8 w-auto md:h-10">
		<span class="font-display text-[20px] md:text-[24px] font-semibold tracking-tight leading-none">
			<span class="text-neutral-900">mundi</span><span class="text-brand-sage">zen</span>
		</span>
	</a>

    {{-- Menú centrado --}}
    <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center gap-8 text-[14px] text-brand-text">
        <a href="{{ route('search') }}" class="{{ $navLink('search') }}">
            Buscar terapias
            @if (request()->routeIs('search'))
                <span class="absolute -bottom-[22px] left-0 right-0 h-0.5 bg-brand-sage rounded-full"></span>
            @endif
        </a>
        <a href="{{ route('my-ads') }}" class="{{ $navLink('my-ads') }}">
            Tus anuncios
            @if (request()->routeIs('my-ads'))
                <span class="absolute -bottom-[22px] left-0 right-0 h-0.5 bg-brand-sage rounded-full"></span>
            @endif
        </a>
        <a href="{{ route('post-ad') }}" class="{{ $navLink('post-ad') }}">
            Pon tu anuncio
            @if (request()->routeIs('post-ad'))
                <span class="absolute -bottom-[22px] left-0 right-0 h-0.5 bg-brand-sage rounded-full"></span>
            @endif
        </a>
        <a href="{{ route('favorites') }}" class="{{ $navLink('favorites') }}">
            Favoritos
            @if (request()->routeIs('favorites'))
                <span class="absolute -bottom-[22px] left-0 right-0 h-0.5 bg-brand-sage rounded-full"></span>
            @endif
        </a>
    </div>

    {{-- CTA --}}
    <div class="flex items-center gap-3">
        @auth
            <x-notification-bell />
            <a href="{{ route('my-ads') }}" class="flex items-center">
                @if (auth()->user()->avatarUrl())
                    <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-full object-cover">
                @else
                    <div class="w-9 h-9 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[12px] font-semibold flex items-center justify-center">{{ auth()->user()->initials() }}</div>
                @endif
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[14px] text-brand-text hover:text-brand-dark transition">Salir</button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="px-[18px] py-[9px] bg-brand-dark text-brand-cream rounded-full text-[13px] font-medium hover:opacity-90 transition">
                Iniciar sesión
            </a>
        @endauth
    </div>
</nav>