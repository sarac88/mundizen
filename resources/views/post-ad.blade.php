@php
    $steps = [
        ['n' => '01', 'label' => 'Categoría'],
        ['n' => '02', 'label' => 'Información'],
        ['n' => '03', 'label' => 'Lugar y modo'],
        ['n' => '04', 'label' => 'Precio y duración'],
        ['n' => '05', 'label' => 'Fotos y publicar'],
    ];

    $cats = [
        ['emoji' => '✋', 'name' => 'Manuales',    'desc' => 'masaje sueco · quiromasaje · reflexología podal'],
        ['emoji' => '✨', 'name' => 'Energéticas', 'desc' => 'reiki · biomagnetismo · sanación cuántica'],
        ['emoji' => '🎓', 'name' => 'Cursos',      'desc' => 'mindfulness · yoga · aromaterapia'],
        ['emoji' => '💧', 'name' => 'Productos',   'desc' => 'aceites esenciales · cosmética natural · cristales'],
    ];

    $certs = ['Quiromasaje (CGS)', 'Reiki nivel II', 'Aromaterapia clínica', 'Mindfulness MBSR'];
    $units = ['Por sesión', 'Por hora', 'Por paquete', 'Por curso completo'];
    $weekdays = [['L', true], ['M', true], ['X', true], ['J', true], ['V', true], ['S', false], ['D', false]];

    $field = 'w-full px-4 py-3 rounded-xl border border-brand-dark/10 bg-white text-[14px] text-brand-dark placeholder:text-brand-muted focus:outline-none focus:border-brand-dark/25';
    $flabel = 'block text-[14px] font-medium mb-2';
@endphp

<x-dashboard title="Pon tu anuncio" active="publicar" :sidebar="false">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-7">
        <div>
            <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">PON TU ANUNCIO —</p>
            <h1 class="font-serif font-normal text-4xl lg:text-[40px] tracking-tight">
                Comparte tu <span class="italic text-brand-sage">práctica.</span>
            </h1>
        </div>
        <a href="{{ route('my-ads') }}" class="shrink-0 inline-flex items-center gap-2 text-[13px] text-brand-text hover:text-brand-dark transition mt-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Salir y guardar borrador
        </a>
    </div>

    {{-- Tarjeta del wizard --}}
    <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.05)] p-6 sm:p-8 max-w-4xl mx-auto" data-wizard>

        {{-- Stepper --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-8">
            @foreach ($steps as $i => $step)
                <div class="flex items-center gap-2.5 shrink-0" data-stepper="{{ $i + 1 }}">
                    <span data-circle class="w-7 h-7 rounded-full flex items-center justify-center text-[12px] font-medium shrink-0 transition">{{ $step['n'] }}</span>
                    <span data-label class="text-[14px] whitespace-nowrap">{{ $step['label'] }}</span>
                </div>
                @if (! $loop->last)
                    <div class="h-px w-8 lg:flex-1 bg-brand-dark/10 shrink-0 lg:shrink"></div>
                @endif
            @endforeach
        </div>

        {{-- ===== Paso 1: Categoría ===== --}}
        <div data-step="1">
            <h2 class="font-serif text-[26px] tracking-tight">¿Qué tipo de servicio ofreces?</h2>
            <p class="text-[15px] text-brand-text mt-1.5 mb-6">Elige una categoría principal. Luego afinaremos.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($cats as $cat)
                    <button type="button" data-cat data-state="off" class="group text-left rounded-2xl border border-brand-dark/10 p-6 flex items-center justify-between gap-4 transition hover:border-brand-dark/25 data-[state=on]:ring-2 data-[state=on]:ring-brand-dark data-[state=on]:border-brand-dark">
                        <div class="flex items-start gap-4">
                            <span class="text-2xl leading-none">{{ $cat['emoji'] }}</span>
                            <div>
                                <p class="font-serif text-[20px] tracking-tight">{{ $cat['name'] }}</p>
                                <p class="text-[13px] text-brand-muted mt-1 leading-snug">{{ $cat['desc'] }}</p>
                            </div>
                        </div>
                        <span class="shrink-0 w-5 h-5 rounded-full border border-brand-dark/25 flex items-center justify-center transition group-data-[state=on]:border-brand-dark">
                            <span class="w-2.5 h-2.5 rounded-full bg-brand-dark scale-0 transition group-data-[state=on]:scale-100"></span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- ===== Paso 2: Información ===== --}}
        <div data-step="2" class="hidden">
            <h2 class="font-serif text-[26px] tracking-tight">Cuenta de qué va</h2>
            <p class="text-[15px] text-brand-text mt-1.5 mb-6">Un buen título y una descripción honesta multiplican los contactos.</p>

            <div class="mb-5">
                <label class="{{ $flabel }}">Título del anuncio</label>
                <input type="text" maxlength="80" placeholder="Ej. Masaje sueco de 60 min en estudio céntrico" class="{{ $field }}" data-title-input>
                <p class="text-[12px] text-brand-muted mt-2">Sé concreto: tipo, duración, ubicación o modo. <span data-title-count>0/80</span></p>
            </div>

            <div class="mb-5">
                <label class="{{ $flabel }}">Descripción</label>
                <textarea rows="5" placeholder="Cuenta qué incluye la sesión, en qué casos ayuda, qué aceites o materiales utilizas..." class="{{ $field }} resize-none"></textarea>
                <p class="text-[12px] text-brand-muted mt-2">Tip: menciona si traes material, si la sala es privada, si trabajas con grupos…</p>
            </div>

            <div>
                <label class="{{ $flabel }}">Certificaciones a mostrar</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($certs as $cert)
                        <button type="button" data-cert data-state="off" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-brand-dark/15 text-[13px] text-brand-text transition data-[state=on]:bg-brand-sage-soft data-[state=on]:border-brand-sage data-[state=on]:text-brand-sage-dark">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="9" r="5" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 13.4L7.5 21l4.5-2.6 4.5 2.6-1.5-7.6" /></svg>
                            {{ $cert }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ===== Paso 3: Lugar y modo ===== --}}
        <div data-step="3" class="hidden">
            <h2 class="font-serif text-[26px] tracking-tight">¿Dónde lo ofreces?</h2>
            <p class="text-[15px] text-brand-text mt-1.5 mb-6">Define cómo trabajas con tus clientes.</p>

            <label class="{{ $flabel }}">Modalidad</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                {{-- Presencial --}}
                <button type="button" data-mode data-state="on" class="rounded-2xl border border-brand-dark/10 p-5 text-left text-brand-dark transition data-[state=on]:bg-brand-dark data-[state=on]:text-brand-cream data-[state=on]:border-brand-dark">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                    <p class="font-medium text-[16px] mt-3">Presencial</p>
                    <p class="text-[13px] opacity-60 mt-0.5">En tu local</p>
                </button>
                {{-- Online --}}
                <button type="button" data-mode data-state="off" class="rounded-2xl border border-brand-dark/10 p-5 text-left text-brand-dark transition data-[state=on]:bg-brand-dark data-[state=on]:text-brand-cream data-[state=on]:border-brand-dark">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                    <p class="font-medium text-[16px] mt-3">Online</p>
                    <p class="text-[13px] opacity-60 mt-0.5">Por videollamada</p>
                </button>
                {{-- A domicilio --}}
                <button type="button" data-mode data-state="off" class="rounded-2xl border border-brand-dark/10 p-5 text-left text-brand-dark transition data-[state=on]:bg-brand-dark data-[state=on]:text-brand-cream data-[state=on]:border-brand-dark">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                    <p class="font-medium text-[16px] mt-3">A domicilio</p>
                    <p class="text-[13px] opacity-60 mt-0.5">Vas al cliente</p>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                <div>
                    <label class="{{ $flabel }}">Ciudad</label>
                    <div class="relative">
                        <select class="{{ $field }} appearance-none pr-10">
                            <option>Selecciona...</option>
                            <option>Valencia</option>
                            <option>Barcelona</option>
                            <option>Madrid</option>
                            <option>Sevilla</option>
                        </select>
                        <svg class="w-4 h-4 text-brand-muted absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                </div>
                <div>
                    <label class="{{ $flabel }}">Dirección o zona</label>
                    <input type="text" placeholder="Ej. C/ Cuba 22, Ruzafa" class="{{ $field }}">
                </div>
            </div>

            <div>
                <label class="{{ $flabel }}">Disponibilidad semanal</label>
                <div class="flex flex-wrap gap-2.5">
                    @foreach ($weekdays as [$day, $on])
                        <button type="button" data-day data-state="{{ $on ? 'on' : 'off' }}" class="w-11 h-11 rounded-full border border-brand-dark/15 text-[14px] font-medium text-brand-text transition data-[state=on]:bg-brand-sage-soft data-[state=on]:border-brand-sage data-[state=on]:text-brand-sage-dark">{{ $day }}</button>
                    @endforeach
                </div>
                <p class="text-[12px] text-brand-muted mt-3">Más adelante podrás abrir un calendario con franjas horarias por día.</p>
            </div>
        </div>

        {{-- ===== Paso 4: Precio y duración ===== --}}
        <div data-step="4" class="hidden">
            <h2 class="font-serif text-[26px] tracking-tight">Precio y duración</h2>
            <p class="text-[15px] text-brand-text mt-1.5 mb-6">Define cómo cobras. Puedes añadir más paquetes después.</p>

            <label class="{{ $flabel }}">Unidad de precio</label>
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach ($units as $i => $unit)
                    <button type="button" data-unit data-state="{{ $i === 0 ? 'on' : 'off' }}" class="px-4 py-2 rounded-full text-[13px] border border-brand-dark/15 text-brand-text transition data-[state=on]:bg-brand-dark data-[state=on]:text-brand-cream data-[state=on]:border-brand-dark">{{ $unit }}</button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="{{ $flabel }}">Precio</label>
                    <div class="flex items-center gap-2">
                        <input type="number" value="45" class="{{ $field }}">
                        <span class="text-[16px] text-brand-text">€</span>
                    </div>
                    <p class="text-[12px] text-brand-muted mt-2">Promedio en tu ciudad: 40-55 € la sesión.</p>
                </div>
                <div>
                    <label class="{{ $flabel }}">Duración (min)</label>
                    <input type="number" value="60" class="{{ $field }}">
                    <p class="text-[12px] text-brand-muted mt-2">Lo más habitual: 30, 60 o 90 minutos.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 px-5 py-4 rounded-xl bg-brand-sand/60">
                <span class="text-[18px]">✺</span>
                <p class="text-[14px] text-brand-text"><span class="font-medium text-brand-dark">Sin comisiones.</span> Mundizen no se queda nada. Tú gestionas el cobro directamente con tu cliente.</p>
            </div>
        </div>

        {{-- ===== Paso 5: Fotos y publicar ===== --}}
        <div data-step="5" class="hidden">
            <h2 class="font-serif text-[26px] tracking-tight">Fotos para tu anuncio</h2>
            <p class="text-[15px] text-brand-text mt-1.5 mb-6">Sube 3-5 fotos. La primera será la principal.</p>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                @foreach (['Principal', 'Añadir', 'Añadir', 'Añadir'] as $slot)
                    <button type="button" class="aspect-square rounded-2xl bg-[#E9E6DD] hover:bg-[#E3E0D5] flex flex-col items-center justify-center gap-2 text-brand-muted transition">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z" /></svg>
                        <span class="text-[12px]">{{ $slot }}</span>
                    </button>
                @endforeach
            </div>

            <div class="px-5 py-5 rounded-xl bg-[#E9E6DD]/70">
                <h3 class="font-serif text-[18px] tracking-tight mb-1.5">Casi listo</h3>
                <p class="text-[14px] text-brand-text leading-relaxed">Tu anuncio se publicará y aparecerá en el listado en menos de 1 minuto. Podrás editarlo o pausarlo cuando quieras desde tu panel.</p>
                <label class="flex items-center gap-2 mt-4 text-[14px] text-brand-text cursor-pointer">
                    <input type="checkbox" checked class="w-4 h-4 rounded accent-brand-dark">
                    Acepto las <a href="#" class="underline hover:text-brand-dark">condiciones de publicación</a>.
                </label>
            </div>
        </div>

        {{-- Pie del wizard --}}
        <div class="border-t border-brand-dark/5 mt-8 pt-6 flex items-center justify-between">
            <button type="button" data-back class="inline-flex items-center gap-2 text-[14px] text-brand-text hover:text-brand-dark transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Atrás
            </button>
            <div class="flex items-center gap-3">
                <button type="button" class="px-5 py-3 rounded-full border border-brand-dark/15 text-[14px] font-medium text-brand-dark hover:bg-brand-sage-soft/40 transition">Guardar borrador</button>
                <button type="button" data-next class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                    Continuar
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
                <button type="button" data-publish class="hidden items-center gap-2 px-6 py-3 bg-brand-sage text-brand-dark rounded-full text-[14px] font-medium hover:opacity-90 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    Publicar anuncio
                </button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const root = document.querySelector('[data-wizard]');
            if (!root) return;

            const steps = [...root.querySelectorAll('[data-step]')];
            const items = [...root.querySelectorAll('[data-stepper]')];
            const backBtn = root.querySelector('[data-back]');
            const nextBtn = root.querySelector('[data-next]');
            const publishBtn = root.querySelector('[data-publish]');
            const total = steps.length;
            let current = 1;

            const check = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>';
            const base = 'w-7 h-7 rounded-full flex items-center justify-center text-[12px] font-medium shrink-0 transition';

            function render() {
                steps.forEach(s => s.classList.toggle('hidden', +s.dataset.step !== current));

                items.forEach(item => {
                    const i = +item.dataset.stepper;
                    const circle = item.querySelector('[data-circle]');
                    const label = item.querySelector('[data-label]');
                    if (i < current) {
                        circle.className = base + ' bg-brand-sage text-brand-dark';
                        circle.innerHTML = check;
                        label.className = 'text-[14px] whitespace-nowrap text-brand-text';
                    } else if (i === current) {
                        circle.className = base + ' bg-brand-dark text-brand-cream';
                        circle.textContent = String(i).padStart(2, '0');
                        label.className = 'text-[14px] whitespace-nowrap text-brand-dark font-medium';
                    } else {
                        circle.className = base + ' bg-brand-dark/5 text-brand-muted';
                        circle.textContent = String(i).padStart(2, '0');
                        label.className = 'text-[14px] whitespace-nowrap text-brand-muted';
                    }
                });

                backBtn.classList.toggle('invisible', current === 1);
                nextBtn.classList.toggle('hidden', current === total);
                nextBtn.classList.toggle('inline-flex', current !== total);
                publishBtn.classList.toggle('hidden', current !== total);
                publishBtn.classList.toggle('inline-flex', current === total);
            }

            nextBtn.addEventListener('click', () => { if (current < total) { current++; render(); } });
            backBtn.addEventListener('click', () => { if (current > 1) { current--; render(); } });
            publishBtn.addEventListener('click', () => alert('¡Anuncio publicado! (demo)'));

            // Selección exclusiva (radio) y múltiple (toggle)
            function exclusive(sel) {
                const group = [...root.querySelectorAll(sel)];
                group.forEach(el => el.addEventListener('click', () => group.forEach(x => x.dataset.state = x === el ? 'on' : 'off')));
            }
            function toggleable(sel) {
                root.querySelectorAll(sel).forEach(el => el.addEventListener('click', () => el.dataset.state = el.dataset.state === 'on' ? 'off' : 'on'));
            }
            exclusive('[data-cat]');
            exclusive('[data-mode]');
            exclusive('[data-unit]');
            toggleable('[data-day]');
            toggleable('[data-cert]');

            // Contador del título
            const titleInput = root.querySelector('[data-title-input]');
            const titleCount = root.querySelector('[data-title-count]');
            if (titleInput && titleCount) {
                titleInput.addEventListener('input', () => titleCount.textContent = titleInput.value.length + '/80');
            }

            render();
        })();
    </script>

</x-dashboard>
