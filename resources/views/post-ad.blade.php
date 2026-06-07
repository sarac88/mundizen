@php
    $steps = [
        ['n' => '01', 'label' => 'Categoría'],
        ['n' => '02', 'label' => 'Información'],
        ['n' => '03', 'label' => 'Lugar y modo'],
        ['n' => '04', 'label' => 'Precio y duración'],
        ['n' => '05', 'label' => 'Fotos y publicar'],
    ];

    $cats = [
        ['icon' => 'hand',           'name' => 'Manuales',    'value' => 'manuales',    'desc' => 'masaje sueco · quiromasaje · reflexología podal'],
        ['icon' => 'sparkles',       'name' => 'Energéticas', 'value' => 'energeticas', 'desc' => 'reiki · biomagnetismo · sanación cuántica'],
        ['icon' => 'graduation-cap', 'name' => 'Cursos',      'value' => 'cursos',      'desc' => 'mindfulness · yoga · aromaterapia'],
        ['icon' => 'droplet',        'name' => 'Productos',   'value' => 'productos',   'desc' => 'aceites esenciales · cosmética natural · cristales'],
    ];

    $certs = ['Quiromasaje (CGS)', 'Reiki nivel II', 'Aromaterapia clínica', 'Mindfulness MBSR'];
    $units = [
        ['label' => 'Por sesión', 'value' => 'por_sesion'],
        ['label' => 'Por hora', 'value' => 'por_hora'],
        ['label' => 'Por paquete', 'value' => 'por_paquete'],
        ['label' => 'Por curso completo', 'value' => 'por_curso'],
    ];
    $modes = [
        ['label' => 'Presencial', 'value' => 'presencial', 'sublabel' => 'En tu local'],
        ['label' => 'Online', 'value' => 'online', 'sublabel' => 'Por videollamada'],
        ['label' => 'A domicilio', 'value' => 'domicilio', 'sublabel' => 'Vas al cliente'],
    ];
    $cities = ['Valencia', 'Barcelona', 'Madrid', 'Sevilla'];
    $weekdays = [['L', true], ['M', true], ['X', true], ['J', true], ['V', true], ['S', false], ['D', false]];

    $oldCategory = old('category');
    $oldMode = old('mode', 'presencial');
    $oldPriceUnit = old('price_unit', 'por_sesion');
    $oldCerts = old('certifications', []);
    $oldAvailability = old('availability', ['L', 'M', 'X', 'J', 'V']);

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
        <button type="submit" form="post-ad-form" name="action" value="draft" class="shrink-0 inline-flex items-center gap-2 text-[13px] text-brand-text hover:text-brand-dark transition mt-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Salir y guardar borrador
        </button>
    </div>

    @if ($errors->any())
        <div class="mb-6 max-w-4xl mx-auto rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-[14px] text-red-700">
            <p class="font-medium mb-2">Revisa los siguientes campos:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="post-ad-form" method="POST" action="{{ route('ads.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="category" id="category-input" value="{{ $oldCategory }}">
        <input type="hidden" name="mode" id="mode-input" value="{{ $oldMode }}">
        <input type="hidden" name="price_unit" id="price-unit-input" value="{{ $oldPriceUnit }}">

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
                        <button type="button" data-cat data-value="{{ $cat['value'] }}" data-state="{{ $oldCategory === $cat['value'] ? 'on' : 'off' }}" class="group text-left rounded-2xl border border-brand-dark/10 p-6 flex items-center justify-between gap-4 transition hover:border-brand-dark/25 data-[state=on]:ring-2 data-[state=on]:ring-brand-dark data-[state=on]:border-brand-dark">
                            <div class="flex items-start gap-4">
                                <x-lucide :name="$cat['icon']" class="w-6 h-6 shrink-0 text-brand-sage-dark" />
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
                @error('category')
                    <p class="text-[13px] text-red-600 mt-3">{{ $message }}</p>
                @enderror
            </div>

            {{-- ===== Paso 2: Información ===== --}}
            <div data-step="2" class="hidden">
                <h2 class="font-serif text-[26px] tracking-tight">Cuenta de qué va</h2>
                <p class="text-[15px] text-brand-text mt-1.5 mb-6">Un buen título y una descripción honesta multiplican los contactos.</p>

                <div class="mb-5">
                    <label class="{{ $flabel }}" for="title">Título del anuncio</label>
                    <input type="text" id="title" name="title" maxlength="80" value="{{ old('title') }}" placeholder="Ej. Masaje sueco de 60 min en estudio céntrico" class="{{ $field }} @error('title') border-red-300 @enderror" data-title-input>
                    <p class="text-[12px] text-brand-muted mt-2">Sé concreto: tipo, duración, ubicación o modo. <span data-title-count>{{ strlen(old('title', '')) }}/80</span></p>
                    @error('title')
                        <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="{{ $flabel }}" for="description">Descripción</label>
                    <textarea id="description" name="description" rows="5" placeholder="Cuenta qué incluye la sesión, en qué casos ayuda, qué aceites o materiales utilizas..." class="{{ $field }} resize-none @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                    <p class="text-[12px] text-brand-muted mt-2">Tip: menciona si traes material, si la sala es privada, si trabajas con grupos…</p>
                </div>

                <div>
                    <label class="{{ $flabel }}">Certificaciones a mostrar</label>
                    <div class="flex flex-wrap gap-2" data-cert-group>
                        @foreach ($certs as $cert)
                            <button type="button" data-cert data-value="{{ $cert }}" data-state="{{ in_array($cert, $oldCerts, true) ? 'on' : 'off' }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-brand-dark/15 text-[13px] text-brand-text transition data-[state=on]:bg-brand-sage-soft data-[state=on]:border-brand-sage data-[state=on]:text-brand-sage-dark">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="9" r="5" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 13.4L7.5 21l4.5-2.6 4.5 2.6-1.5-7.6" /></svg>
                                {{ $cert }}
                            </button>
                        @endforeach
                    </div>
                    <div data-cert-inputs>
                        @foreach ($oldCerts as $cert)
                            <input type="hidden" name="certifications[]" value="{{ $cert }}">
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
                    @foreach ($modes as $mode)
                        <button type="button" data-mode data-value="{{ $mode['value'] }}" data-state="{{ $oldMode === $mode['value'] ? 'on' : 'off' }}" class="rounded-2xl border border-brand-dark/10 p-5 text-left text-brand-dark transition data-[state=on]:bg-brand-dark data-[state=on]:text-brand-cream data-[state=on]:border-brand-dark">
                            @if ($mode['value'] === 'presencial')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                            @elseif ($mode['value'] === 'online')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            @endif
                            <p class="font-medium text-[16px] mt-3">{{ $mode['label'] }}</p>
                            <p class="text-[13px] opacity-60 mt-0.5">{{ $mode['sublabel'] }}</p>
                        </button>
                    @endforeach
                </div>
                @error('mode')
                    <p class="text-[13px] text-red-600 mb-4">{{ $message }}</p>
                @enderror

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="{{ $flabel }}" for="city">Ciudad</label>
                        <div class="relative">
                            <select id="city" name="city" class="{{ $field }} appearance-none pr-10 @error('city') border-red-300 @enderror">
                                <option value="">Selecciona...</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}" @selected(old('city') === $city)>{{ $city }}</option>
                                @endforeach
                            </select>
                            <svg class="w-4 h-4 text-brand-muted absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </div>
                    </div>
                    <div>
                        <label class="{{ $flabel }}" for="address">Dirección o zona</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Ej. C/ Cuba 22, Ruzafa" class="{{ $field }} @error('address') border-red-300 @enderror">
                    </div>
                </div>

                <div>
                    <label class="{{ $flabel }}">Disponibilidad semanal</label>
                    <div class="flex flex-wrap gap-2.5" data-day-group>
                        @foreach ($weekdays as [$day, $on])
                            <button type="button" data-day data-value="{{ $day }}" data-state="{{ in_array($day, $oldAvailability, true) ? 'on' : 'off' }}" class="w-11 h-11 rounded-full border border-brand-dark/15 text-[14px] font-medium text-brand-text transition data-[state=on]:bg-brand-sage-soft data-[state=on]:border-brand-sage data-[state=on]:text-brand-sage-dark">{{ $day }}</button>
                        @endforeach
                    </div>
                    <div data-day-inputs>
                        @foreach ($oldAvailability as $day)
                            <input type="hidden" name="availability[]" value="{{ $day }}">
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
                    @foreach ($units as $unit)
                        <button type="button" data-unit data-value="{{ $unit['value'] }}" data-state="{{ $oldPriceUnit === $unit['value'] ? 'on' : 'off' }}" class="px-4 py-2 rounded-full text-[13px] border border-brand-dark/15 text-brand-text transition data-[state=on]:bg-brand-dark data-[state=on]:text-brand-cream data-[state=on]:border-brand-dark">{{ $unit['label'] }}</button>
                    @endforeach
                </div>
                @error('price_unit')
                    <p class="text-[13px] text-red-600 mb-4">{{ $message }}</p>
                @enderror

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="{{ $flabel }}" for="price">Precio</label>
                        <div class="flex items-center gap-2">
                            <input type="number" id="price" name="price" min="0" step="0.01" value="{{ old('price', '45') }}" class="{{ $field }} @error('price') border-red-300 @enderror">
                            <span class="text-[16px] text-brand-text">€</span>
                        </div>
                        <p class="text-[12px] text-brand-muted mt-2">Promedio en tu ciudad: 40-55 € la sesión.</p>
                        @error('price')
                            <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="{{ $flabel }}" for="duration">Duración (min)</label>
                        <input type="number" id="duration" name="duration" min="1" value="{{ old('duration', '60') }}" class="{{ $field }} @error('duration') border-red-300 @enderror">
                        <p class="text-[12px] text-brand-muted mt-2">Lo más habitual: 30, 60 o 90 minutos.</p>
                        @error('duration')
                            <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 px-5 py-4 rounded-xl bg-brand-sand/60">
                    <x-lucide name="sparkles" class="w-5 h-5 shrink-0 text-brand-sage-dark" />
                    <p class="text-[14px] text-brand-text"><span class="font-medium text-brand-dark">Sin comisiones.</span> Mundizen no se queda nada. Tú gestionas el cobro directamente con tu cliente.</p>
                </div>
            </div>

            {{-- ===== Paso 5: Fotos y publicar ===== --}}
            <div data-step="5" class="hidden">
                <h2 class="font-serif text-[26px] tracking-tight">Fotos para tu anuncio</h2>
                <p class="text-[15px] text-brand-text mt-1.5 mb-6">Sube 3-5 fotos. La primera será la principal.</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6" data-photo-slots>
                    @foreach (['Principal', 'Añadir', 'Añadir', 'Añadir'] as $index => $slot)
                        <label class="aspect-square rounded-2xl bg-[#E9E6DD] hover:bg-[#E3E0D5] flex flex-col items-center justify-center gap-2 text-brand-muted transition cursor-pointer overflow-hidden relative" data-photo-slot>
                            <input type="file" name="photos[]" accept="image/jpeg,image/jpg,image/png,image/webp" class="sr-only" data-photo-input>
                            <span data-photo-placeholder class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z" /></svg>
                                <span class="text-[12px]">{{ $slot }}</span>
                            </span>
                            <img data-photo-preview class="absolute inset-0 w-full h-full object-cover hidden" alt="">
                        </label>
                    @endforeach
                </div>
                @error('photos')
                    <p class="text-[13px] text-red-600 mb-4">{{ $message }}</p>
                @enderror
                @error('photos.*')
                    <p class="text-[13px] text-red-600 mb-4">{{ $message }}</p>
                @enderror

                <div class="px-5 py-5 rounded-xl bg-[#E9E6DD]/70">
                    <h3 class="font-serif text-[18px] tracking-tight mb-1.5">Casi listo</h3>
                    <p class="text-[14px] text-brand-text leading-relaxed">Tu anuncio se publicará y aparecerá en el listado en menos de 1 minuto. Podrás editarlo o pausarlo cuando quieras desde tu panel.</p>
                    <label class="flex items-center gap-2 mt-4 text-[14px] text-brand-text cursor-pointer">
                        <input type="checkbox" name="terms" value="1" @checked(old('terms')) class="w-4 h-4 rounded accent-brand-dark @error('terms') border-red-300 @enderror">
                        Acepto las <a href="#" class="underline hover:text-brand-dark">condiciones de publicación</a>.
                    </label>
                    @error('terms')
                        <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Pie del wizard --}}
            <div class="border-t border-brand-dark/5 mt-8 pt-6 flex items-center justify-between">
                <button type="button" data-back class="inline-flex items-center gap-2 text-[14px] text-brand-text hover:text-brand-dark transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Atrás
                </button>
                <div class="flex items-center gap-3">
                    <button type="submit" name="action" value="draft" class="px-5 py-3 rounded-full border border-brand-dark/15 text-[14px] font-medium text-brand-dark hover:bg-brand-sage-soft/40 transition">Guardar borrador</button>
                    <button type="button" data-next class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                        Continuar
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                    <button type="submit" name="action" value="publish" data-publish class="hidden items-center gap-2 px-6 py-3 bg-brand-sage text-brand-dark rounded-full text-[14px] font-medium hover:opacity-90 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        Publicar anuncio
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        (function () {
            const root = document.querySelector('[data-wizard]');
            if (!root) return;

            const steps = [...root.querySelectorAll('[data-step]')];
            const items = [...root.querySelectorAll('[data-stepper]')];
            const backBtn = root.querySelector('[data-back]');
            const nextBtn = root.querySelector('[data-next]');
            const publishBtn = root.querySelector('[data-publish]');
            const categoryInput = document.getElementById('category-input');
            const modeInput = document.getElementById('mode-input');
            const priceUnitInput = document.getElementById('price-unit-input');
            const certInputs = document.querySelector('[data-cert-inputs]');
            const dayInputs = document.querySelector('[data-day-inputs]');
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

            function exclusive(sel, hiddenInput) {
                const group = [...root.querySelectorAll(sel)];
                group.forEach(el => el.addEventListener('click', () => {
                    group.forEach(x => x.dataset.state = x === el ? 'on' : 'off');
                    if (hiddenInput) hiddenInput.value = el.dataset.value;
                }));
            }

            function syncToggleInputs(selector, container) {
                const selected = [...root.querySelectorAll(selector)]
                    .filter(el => el.dataset.state === 'on')
                    .map(el => el.dataset.value);

                container.innerHTML = '';
                selected.forEach(value => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = selector.includes('cert') ? 'certifications[]' : 'availability[]';
                    input.value = value;
                    container.appendChild(input);
                });
            }

            function toggleable(sel, container) {
                root.querySelectorAll(sel).forEach(el => el.addEventListener('click', () => {
                    el.dataset.state = el.dataset.state === 'on' ? 'off' : 'on';
                    syncToggleInputs(sel, container);
                }));
            }

            exclusive('[data-cat]', categoryInput);
            exclusive('[data-mode]', modeInput);
            exclusive('[data-unit]', priceUnitInput);
            toggleable('[data-cert]', certInputs);
            toggleable('[data-day]', dayInputs);

            root.querySelectorAll('[data-photo-slot]').forEach(slot => {
                const input = slot.querySelector('[data-photo-input]');
                const placeholder = slot.querySelector('[data-photo-placeholder]');
                const preview = slot.querySelector('[data-photo-preview]');

                input.addEventListener('change', () => {
                    const file = input.files?.[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                });
            });

            const titleInput = root.querySelector('[data-title-input]');
            const titleCount = root.querySelector('[data-title-count]');
            if (titleInput && titleCount) {
                titleInput.addEventListener('input', () => titleCount.textContent = titleInput.value.length + '/80');
            }

            @if ($errors->any())
                current = {{ max(1, min(5, match(true) {
                    $errors->has('photos') || $errors->has('photos.*') || $errors->has('terms') => 5,
                    $errors->has('price') || $errors->has('duration') || $errors->has('price_unit') => 4,
                    $errors->has('mode') || $errors->has('city') || $errors->has('address') => 3,
                    $errors->has('title') || $errors->has('description') => 2,
                    $errors->has('category') => 1,
                    default => 1,
                })) }};
            @endif

            render();
        })();
    </script>

</x-dashboard>
