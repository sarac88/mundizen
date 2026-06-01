@php
    $languages = [
        ['name' => 'Español',  'active' => true],
        ['name' => 'Inglés',   'active' => true],
        ['name' => 'Catalán',  'active' => false],
        ['name' => 'Francés',  'active' => false],
        ['name' => 'Alemán',   'active' => false],
        ['name' => 'Italiano', 'active' => false],
    ];

    $certs = [
        ['name' => 'Quiromasaje (CGS)',    'year' => '2018', 'status' => 'Verif.'],
        ['name' => 'Reiki nivel II',        'year' => '2020', 'status' => 'Verif.'],
        ['name' => 'Aromaterapia clínica',  'year' => '2022', 'status' => 'Pendiente'],
    ];

    $stripes = 'background-image: repeating-linear-gradient(45deg, transparent, transparent 9px, rgba(42,61,54,0.05) 9px, rgba(42,61,54,0.05) 10px);';

    $field = 'w-full px-4 py-3 rounded-xl border border-brand-dark/10 bg-transparent text-[14px] text-brand-dark placeholder:text-brand-muted focus:outline-none focus:border-brand-dark/25';
    $label = 'block text-[13px] font-medium mb-2';
@endphp

<x-dashboard title="Editar perfil" active="perfil">

    {{-- Encabezado --}}
    <div class="mb-7">
        <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">TU PRESENCIA —</p>
        <h1 class="font-serif font-normal text-4xl lg:text-[40px] tracking-tight">
            Cuida tu <span class="italic text-brand-sage">presentación.</span>
        </h1>
        <p class="text-[15px] text-brand-text mt-2">Así te verán quienes te encuentren en Mundizen.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-6 items-start">

        {{-- ===== Formulario ===== --}}
        <form class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-6 sm:p-8">
            <h2 class="font-serif text-[22px] tracking-tight mb-6">Información personal</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-5">
                {{-- Nombre público --}}
                <div>
                    <label class="{{ $label }}">Nombre público</label>
                    <input type="text" value="Marta Llorente" class="{{ $field }}">
                </div>
                {{-- Ciudad --}}
                <div>
                    <label class="{{ $label }}">Ciudad</label>
                    <input type="text" value="Valencia" class="{{ $field }}">
                </div>
                {{-- Email --}}
                <div>
                    <label class="{{ $label }}">Email</label>
                    <input type="email" value="marta@mundizen.com" class="{{ $field }}">
                </div>
                {{-- Teléfono --}}
                <div>
                    <label class="{{ $label }}">Teléfono</label>
                    <input type="tel" value="+34 657 643 224" class="{{ $field }}">
                </div>
                {{-- Web / portfolio --}}
                <div class="sm:col-span-2">
                    <label class="{{ $label }}">Web / portfolio</label>
                    <input type="text" value="martallorente.com" class="{{ $field }}">
                </div>
                {{-- Bio --}}
                <div class="sm:col-span-2">
                    <label class="{{ $label }}">Bio (visible en tus anuncios)</label>
                    <textarea rows="3" class="{{ $field }} resize-none">Terapeuta certificada en masaje sueco y aromaterapia. 8 años acompañando procesos de descanso y equilibrio.</textarea>
                    <p class="text-[12px] text-brand-muted mt-2">Cuenta tu enfoque, formación y por qué haces lo que haces. Máx 300 caracteres.</p>
                </div>
            </div>

            {{-- Idiomas --}}
            <div class="mt-6">
                <label class="{{ $label }}">Idiomas</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($languages as $lang)
                        @if ($lang['active'])
                            <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-brand-dark text-brand-cream text-[13px] font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ $lang['name'] }}
                            </button>
                        @else
                            <button type="button" class="px-4 py-2 rounded-full border border-brand-dark/15 text-[13px] text-brand-text hover:bg-brand-sage-soft/40 transition">
                                {{ $lang['name'] }}
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center gap-5 mt-8">
                <button type="submit" class="px-6 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                    Guardar cambios
                </button>
                <a href="{{ route('my-ads') }}" class="text-[14px] text-brand-text hover:text-brand-dark transition">Cancelar</a>
            </div>
        </form>

        {{-- ===== Columna derecha ===== --}}
        <div class="flex flex-col gap-6">

            {{-- Tarjeta de vista previa --}}
            <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-6 flex flex-col items-center text-center">
                <div class="w-28 h-28 rounded-full bg-brand-cream flex items-center justify-center text-[11px] text-brand-dark/35 text-center leading-tight" style="{{ $stripes }}">
                    [ foto perfil ]
                </div>
                <p class="font-serif text-[22px] tracking-tight mt-5">Marta Llorente</p>
                <p class="text-[13px] text-brand-muted flex items-center gap-1 mt-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    Valencia · desde marzo 2024
                </p>
                <div class="flex items-center gap-2 mt-4">
                    <span class="font-serif text-[18px] font-medium">4.9 ★</span>
                    <span class="text-[13px] text-brand-muted">142 reseñas</span>
                </div>
                <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 mt-5 rounded-full border border-brand-dark/15 text-[13px] font-medium text-brand-dark hover:bg-brand-sage-soft/40 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    Cambiar foto
                </button>
            </div>

            {{-- Tarjeta de certificaciones --}}
            <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-serif text-[18px] tracking-tight">Certificaciones</h2>
                    <button type="button" class="inline-flex items-center gap-1.5 text-[13px] text-brand-text hover:text-brand-dark transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Añadir
                    </button>
                </div>

                <div class="flex flex-col gap-2.5">
                    @foreach ($certs as $cert)
                        <div class="flex items-center gap-3 bg-[#F5F2EA] rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 shrink-0 text-brand-sage-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="9" r="5" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13.4L7.5 21l4.5-2.6 4.5 2.6-1.5-7.6" />
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-[14px] font-medium leading-tight truncate">{{ $cert['name'] }}</p>
                                <p class="text-[12px] text-brand-muted mt-0.5">{{ $cert['year'] }}</p>
                            </div>
                            @if ($cert['status'] === 'Verif.')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-brand-sage/15 text-brand-sage-dark text-[12px] font-medium shrink-0">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    Verif.
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-brand-dark/5 text-brand-muted text-[12px] font-medium shrink-0">
                                    Pendiente
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-dashboard>
