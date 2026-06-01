<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-brand-cream text-brand-dark font-sans antialiased overflow-x-hidden">
        <div class="relative grid min-h-svh flex-col items-center justify-center px-6 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">

            {{-- Panel izquierdo: imagen + marca (solo desktop) --}}
            <div class="relative hidden h-full flex-col p-10 text-brand-cream lg:flex overflow-hidden">
                {{-- Imagen de fondo --}}
                <div class="absolute inset-0 bg-cover bg-center"
                     style="background-image: url('https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=1200&q=80');"></div>
                {{-- Overlay de marca: degradado para dejar respirar el color --}}
                <div class="absolute inset-0 bg-gradient-to-b from-brand-dark/90 via-brand-dark/40 to-brand-dark/20"></div>

                {{-- Tagline (arriba) --}}
                <div class="relative z-20">
                    <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-3">— RESPIRA, EQUILIBRA, SANA —</p>
                    <h2 class="font-serif font-normal text-4xl leading-[1.1] tracking-tight">
                        El cuidado que buscabas,<br>
                        <span class="italic text-brand-sage">cerca de donde estás.</span><br>
                    </h2>
                </div>
            </div>

            {{-- Panel derecho: formulario --}}
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center gap-6 sm:w-[360px]">
                    {{-- Logo encima del formulario --}}
                    <a href="{{ route('home') }}" class="z-20 flex items-center gap-2.5" wire:navigate>
                        <img src="/images/logo.svg" alt="Mundizen" class="h-12 w-auto">
                        <span class="font-display text-[28px] font-semibold tracking-tight leading-none">
                            <span class="text-brand-dark">mundi</span><span class="text-brand-sage">zen</span>
                        </span>
                    </a>

                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
