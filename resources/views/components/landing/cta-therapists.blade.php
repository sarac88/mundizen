<section class="relative px-4 py-8 md:px-6 md:py-10 lg:px-9 lg:py-16">

    {{-- Formas decorativas exteriores (alrededor de la caja oscura) --}}
    <x-landing.shapes type="blob-sky"
        class="pointer-events-none hidden lg:block absolute -top-15 -left-12 w-56 h-56 z-0 animate-[float-drift_5s_ease-in-out_infinite]" />
    <x-landing.shapes type="wave-sage"
        class="pointer-events-none hidden md:block absolute top-20 right-24 w-36 h-20 z-0" />
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
                    <a href="{{ route('post-ad') }}"
                       class="bg-brand-cream text-brand-dark px-6 py-3.5 rounded-full text-[13px] font-medium hover:opacity-90 transition">
                        Publicar anuncio
                    </a>
                    <button type="button" data-howto-open
                       class="bg-transparent text-brand-cream border border-white/25 px-6 py-3.5 rounded-full text-[13px] font-medium hover:bg-white/5 transition">
                        Ver cómo funciona
                    </button>
                </div>
            </div>

            {{-- Columna derecha: imagen en forma orgánica --}}
            <div class="hidden lg:block lg:relative lg:z-10 lg:h-80">
                <div class="absolute inset-0 bg-cover bg-center"
                     style="border-radius: 65% 35% 55% 45% / 50% 45% 55% 50%; background-image: url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80');">
                </div>
            </div>

        </div>
    </div>

    {{-- ===== Modal: cómo funciona ===== --}}
    @php
        $howtoSteps = [
            ['icon' => 'pencil',         'title' => 'Crea tu anuncio',        'desc' => 'Publica tu práctica gratis en unos minutos. Tú eliges qué mostrar.'],
            ['icon' => 'message-circle', 'title' => 'Conecta con clientes',    'desc' => 'Recibe mensajes de personas interesadas directamente en tu bandeja.'],
            ['icon' => 'calendar',       'title' => 'Gestiona tu agenda',      'desc' => 'Acuerda sesiones y horarios a tu ritmo, sin intermediarios.'],
            ['icon' => 'wallet',         'title' => 'Cobra sin comisiones',    'desc' => 'Tú gestionas el pago con tu cliente. Mundizen no se queda nada.'],
        ];
    @endphp
    <div data-howto-modal
         class="hidden fixed inset-0 z-[100] items-center justify-center p-4 bg-brand-dark/50 backdrop-blur-sm opacity-0 transition-opacity duration-200"
         role="dialog" aria-modal="true" aria-labelledby="howto-title">
        <div data-howto-panel
             class="relative bg-brand-cream w-full max-w-lg rounded-3xl shadow-[0_24px_80px_rgba(42,61,54,0.25)] p-6 sm:p-8 max-h-[90vh] overflow-y-auto scale-95 opacity-0 transition-all duration-200">

            {{-- Cerrar --}}
            <button type="button" data-howto-close aria-label="Cerrar"
                    class="absolute top-5 right-5 w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark hover:bg-brand-dark/5 transition">
                <x-lucide name="x" class="w-4 h-4" />
            </button>

            {{-- Cabecera --}}
            <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">CÓMO FUNCIONA —</p>
            <h3 id="howto-title" class="font-serif font-normal text-[28px] tracking-tight">Publicar es así de simple.</h3>
            <p class="text-[14px] text-brand-text leading-relaxed mt-2 mb-6">Cuatro pasos para empezar a recibir clientes. Sin cuotas ni letra pequeña.</p>

            {{-- Pasos --}}
            <div class="flex flex-col gap-5">
                @foreach ($howtoSteps as $i => $step)
                    <div class="flex items-start gap-4">
                        <div class="relative shrink-0">
                            <div class="w-11 h-11 rounded-full bg-brand-sage-soft text-brand-sage-dark flex items-center justify-center">
                                <x-lucide :name="$step['icon']" class="w-5 h-5" />
                            </div>
                            <span class="absolute -top-1.5 -left-1.5 w-5 h-5 rounded-full bg-brand-dark text-brand-cream text-[11px] font-semibold flex items-center justify-center">{{ $i + 1 }}</span>
                        </div>
                        <div class="pt-1">
                            <p class="text-[15px] font-medium leading-tight">{{ $step['title'] }}</p>
                            <p class="text-[13px] text-brand-text leading-relaxed mt-1">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- CTA --}}
            <a href="{{ route('post-ad') }}"
               class="mt-7 w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                Empezar ahora
                <x-lucide name="heart" class="w-4 h-4" />
            </a>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.querySelector('[data-howto-modal]');
            if (!modal) return;
            const panel = modal.querySelector('[data-howto-panel]');
            const openers = document.querySelectorAll('[data-howto-open]');

            function open() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                requestAnimationFrame(() => {
                    modal.classList.remove('opacity-0');
                    panel.classList.remove('scale-95', 'opacity-0');
                });
            }
            function close() {
                modal.classList.add('opacity-0');
                panel.classList.add('scale-95', 'opacity-0');
                document.body.style.overflow = '';
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }

            openers.forEach(b => b.addEventListener('click', open));
            modal.querySelectorAll('[data-howto-close]').forEach(b => b.addEventListener('click', close));
            modal.addEventListener('click', e => { if (e.target === modal) close(); });
            document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) close(); });
        })();
    </script>
</section>