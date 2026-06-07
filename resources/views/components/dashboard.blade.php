@props([
    'title' => null,
    'active' => '',
    'sidebar' => true,
])

@php
    $navLink = fn ($key) => $active === $key
        ? 'relative text-brand-dark font-medium'
        : 'hover:text-brand-dark transition';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title.' · ' : '' }}{{ config('app.name', 'Mundizen') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;1,9..144,400;1,9..144,500&family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-brand-cream text-brand-dark min-h-screen font-sans antialiased flex flex-col">

        {{-- ===== Barra superior ===== --}}
        <nav class="sticky top-0 z-50 flex items-center justify-between px-4 py-4 md:px-6 lg:px-9 bg-brand-cream/75 backdrop-blur-md border-b border-brand-dark/5">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <img src="/images/logo.svg" alt="Mundizen" class="h-9 w-auto">
                <span class="font-display text-[22px] font-semibold tracking-tight leading-none">
                    <span class="text-brand-dark">mundi</span><span class="text-brand-sage">zen</span>
                </span>
            </a>

            {{-- Menú central --}}
            <div class="hidden lg:flex items-center gap-8 text-[14px] text-brand-text">
                <a href="{{ route('search') }}" class="hover:text-brand-dark transition">Buscar terapias</a>
                <a href="{{ route('my-ads') }}" class="{{ $navLink('anuncios') }}">
                    Tus anuncios
                    @if ($active === 'anuncios')
                        <span class="absolute -bottom-[22px] left-0 right-0 h-0.5 bg-brand-sage rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('post-ad') }}" class="{{ $navLink('publicar') }}">
                    Pon tu anuncio
                    @if ($active === 'publicar')
                        <span class="absolute -bottom-[22px] left-0 right-0 h-0.5 bg-brand-sage rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('favorites') }}" class="{{ $navLink('favoritos') }}">
                    Favoritos
                    @if ($active === 'favoritos')
                        <span class="absolute -bottom-[22px] left-0 right-0 h-0.5 bg-brand-sage rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('messages') }}" class="{{ $navLink('mensajes') }}">
                    Mensajes
                    @if ($active === 'mensajes')
                        <span class="absolute -bottom-[22px] left-0 right-0 h-0.5 bg-brand-sage rounded-full"></span>
                    @endif
                </a>
            </div>

            {{-- Acciones derecha --}}
            <div class="flex items-center gap-3">
                <button class="relative w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition">
                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <span class="absolute top-1.5 right-2 w-2 h-2 rounded-full bg-brand-sage ring-2 ring-brand-cream"></span>
                </button>
                <div class="w-9 h-9 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[12px] font-semibold flex items-center justify-center">ML</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[14px] text-brand-text hover:text-brand-dark transition">Salir</button>
                </form>
            </div>
        </nav>

        {{-- ===== Contenido ===== --}}
        @unless ($sidebar)
            <main class="flex-1 w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-9 py-8">
                {{ $slot }}
            </main>
        @else
        <div class="flex-1 w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-9 py-8 grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-6 items-start">

            {{-- ===== Sidebar ===== --}}
            <aside class="flex flex-col gap-5">

                {{-- Tarjeta de perfil --}}
                <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.05)] p-5">
                    <div class="flex items-center gap-3 pb-4 border-b border-brand-dark/5">
                        <div class="w-11 h-11 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[14px] font-semibold flex items-center justify-center">ML</div>
                        <div>
                            <p class="text-[15px] font-medium leading-tight">Marta Llorente</p>
                            <p class="text-[12px] text-brand-muted flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                Valencia
                            </p>
                        </div>
                    </div>

                    <nav class="flex flex-col gap-1 pt-4">
                        {{-- Mis anuncios --}}
                        <a href="{{ route('my-ads') }}" @class([
                            'flex items-center justify-between px-3 py-2.5 rounded-xl transition',
                            'bg-brand-dark text-brand-cream' => $active === 'anuncios',
                            'text-brand-text hover:bg-brand-sage-soft/50' => $active !== 'anuncios',
                        ])>
                            <span class="flex items-center gap-2.5 text-[14px] {{ $active === 'anuncios' ? 'font-medium' : '' }}">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>
                                Mis anuncios
                            </span>
                            <span @class([
                                'w-5 h-5 rounded-full text-[11px] font-semibold flex items-center justify-center',
                                'bg-brand-sage text-brand-dark' => $active === 'anuncios',
                                'bg-brand-dark/5 text-brand-text' => $active !== 'anuncios',
                            ])>4</span>
                        </a>
                        {{-- Favoritos --}}
                        <a href="{{ route('favorites') }}" @class([
                            'flex items-center justify-between px-3 py-2.5 rounded-xl transition',
                            'bg-brand-dark text-brand-cream' => $active === 'favoritos',
                            'text-brand-text hover:bg-brand-sage-soft/50' => $active !== 'favoritos',
                        ])>
                            <span class="flex items-center gap-2.5 text-[14px] {{ $active === 'favoritos' ? 'font-medium' : '' }}">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                Favoritos
                            </span>
                            <span @class([
                                'w-5 h-5 rounded-full text-[11px] font-semibold flex items-center justify-center',
                                'bg-brand-sage text-brand-dark' => $active === 'favoritos',
                                'bg-brand-dark/5 text-brand-text' => $active !== 'favoritos',
                            ])>{{ auth()->user()->favorites()->count() }}</span>
                        </a>
                        {{-- Mensajes --}}
                        <a href="{{ route('messages') }}" @class([
                            'flex items-center justify-between px-3 py-2.5 rounded-xl transition',
                            'bg-brand-dark text-brand-cream' => $active === 'mensajes',
                            'text-brand-text hover:bg-brand-sage-soft/50' => $active !== 'mensajes',
                        ])>
                            <span class="flex items-center gap-2.5 text-[14px] {{ $active === 'mensajes' ? 'font-medium' : '' }}">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                </svg>
                                Mensajes
                            </span>
                            <span class="w-5 h-5 rounded-full bg-brand-sage text-brand-dark text-[11px] font-semibold flex items-center justify-center">3</span>
                        </a>
                        {{-- Editar perfil --}}
                        <a href="{{ route('edit-profile') }}" @class([
                            'flex items-center px-3 py-2.5 rounded-xl transition',
                            'bg-brand-dark text-brand-cream' => $active === 'perfil',
                            'text-brand-text hover:bg-brand-sage-soft/50' => $active !== 'perfil',
                        ])>
                            <span class="flex items-center gap-2.5 text-[14px] {{ $active === 'perfil' ? 'font-medium' : '' }}">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Editar perfil
                            </span>
                        </a>
                    </nav>
                </div>

                {{-- Tarjeta de verificación --}}
                <div class="bg-brand-sage-soft rounded-2xl p-5">
                    <p class="text-[11px] text-brand-sage-dark font-medium tracking-[2px] mb-2.5">VERIFICACIÓN —</p>
                    <p class="text-[13px] text-brand-text leading-relaxed mb-4">
                        Sube tus certificaciones para obtener el sello <span class="italic">Verificado</span> y aparecer en lo alto del listado.
                    </p>
                    <a href="#" class="inline-block px-4 py-2.5 bg-brand-dark text-brand-cream rounded-full text-[13px] font-medium hover:opacity-90 transition">
                        Verificar ahora
                    </a>
                </div>
            </aside>

            {{-- ===== Panel principal ===== --}}
            <main>
                {{ $slot }}
            </main>
        </div>
        @endunless

        {{-- ===== Footer ===== --}}
        <footer class="border-t border-brand-dark/5">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-9 py-7 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="/images/logo.svg" alt="Mundizen" class="h-8 w-auto">
                    <span class="font-display text-[20px] font-semibold tracking-tight">
                        <span class="text-brand-dark">mundi</span><span class="text-brand-sage">zen</span>
                    </span>
                </a>
                <p class="font-serif italic text-[13px] text-brand-muted tracking-wide">— tu espacio de terapias naturales —</p>
                <div class="flex items-center gap-5 text-[13px] text-brand-text">
                    <a href="#" class="hover:text-brand-dark transition">Condiciones</a>
                    <a href="#" class="hover:text-brand-dark transition">Privacidad</a>
                    <a href="#" class="hover:text-brand-dark transition">Cookies</a>
                </div>
            </div>
        </footer>
    </body>
</html>
