@php
    $languageOptions = ['Español', 'Inglés', 'Catalán', 'Francés', 'Alemán', 'Italiano'];
    $oldLanguages = old('languages', $user->languages ?? []);

    $certs = [
        ['name' => 'Quiromasaje (CGS)',    'year' => '2018', 'status' => 'Verif.'],
        ['name' => 'Reiki nivel II',        'year' => '2020', 'status' => 'Verif.'],
        ['name' => 'Aromaterapia clínica',  'year' => '2022', 'status' => 'Pendiente'],
    ];

    $stripes = 'background-image: repeating-linear-gradient(45deg, transparent, transparent 9px, rgba(42,61,54,0.05) 9px, rgba(42,61,54,0.05) 10px);';

    $field = 'w-full px-4 py-3 rounded-xl border border-brand-dark/10 bg-transparent text-[14px] text-brand-dark placeholder:text-brand-muted focus:outline-none focus:border-brand-dark/25';
    $label = 'block text-[13px] font-medium mb-2';
    $bioValue = old('bio', $user->bio ?? '');
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

    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-brand-sage/30 bg-brand-sage-soft px-5 py-4 text-[14px] text-brand-sage-dark">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-[14px] text-red-700">
            <p class="font-medium mb-2">Revisa los siguientes campos:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="edit-profile-form" method="POST" action="{{ route('edit-profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-6 items-start">

            {{-- ===== Formulario ===== --}}
            <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-6 sm:p-8">
                <h2 class="font-serif text-[22px] tracking-tight mb-6">Información personal</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-5">
                    {{-- Nombre público --}}
                    <div>
                        <label class="{{ $label }}" for="name">Nombre público</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="{{ $field }} @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Ciudad --}}
                    <div>
                        <label class="{{ $label }}" for="city">Ciudad</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" class="{{ $field }} @error('city') border-red-300 @enderror">
                    </div>
                    {{-- Email --}}
                    <div>
                        <label class="{{ $label }}" for="email">Email</label>
                        <input type="email" id="email" value="{{ $user->email }}" readonly class="{{ $field }} bg-brand-dark/5 text-brand-muted cursor-not-allowed">
                        <p class="text-[12px] text-brand-muted mt-2">El email se gestiona en Ajustes.</p>
                    </div>
                    {{-- Teléfono --}}
                    <div>
                        <label class="{{ $label }}" for="phone">Teléfono</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="{{ $field }} @error('phone') border-red-300 @enderror">
                    </div>
                    {{-- Web / portfolio --}}
                    <div class="sm:col-span-2">
                        <label class="{{ $label }}" for="website">Web / portfolio</label>
                        <input type="text" id="website" name="website" value="{{ old('website', $user->website) }}" placeholder="tudominio.com" class="{{ $field }} @error('website') border-red-300 @enderror">
                    </div>
                    {{-- Bio --}}
                    <div class="sm:col-span-2">
                        <label class="{{ $label }}" for="bio">Bio (visible en tus anuncios)</label>
                        <textarea id="bio" name="bio" rows="3" maxlength="300" data-bio-input class="{{ $field }} resize-none @error('bio') border-red-300 @enderror">{{ $bioValue }}</textarea>
                        <p class="text-[12px] text-brand-muted mt-2">Cuenta tu enfoque, formación y por qué haces lo que haces. <span data-bio-count>{{ strlen($bioValue) }}/300</span></p>
                        @error('bio')
                            <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Idiomas --}}
                <div class="mt-6">
                    <label class="{{ $label }}">Idiomas</label>
                    <div class="flex flex-wrap gap-2" data-lang-group>
                        @foreach ($languageOptions as $lang)
                            @php $isActive = in_array($lang, $oldLanguages, true); @endphp
                            <button
                                type="button"
                                data-lang
                                data-value="{{ $lang }}"
                                data-state="{{ $isActive ? 'on' : 'off' }}"
                                @class([
                                    'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-[13px] font-medium transition',
                                    'bg-brand-dark text-brand-cream' => $isActive,
                                    'border border-brand-dark/15 text-brand-text hover:bg-brand-sage-soft/40' => ! $isActive,
                                ])
                            >
                                <svg data-lang-check @class(['w-3.5 h-3.5', 'hidden' => ! $isActive]) fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ $lang }}
                            </button>
                        @endforeach
                    </div>
                    <div data-lang-inputs>
                        @foreach ($oldLanguages as $lang)
                            <input type="hidden" name="languages[]" value="{{ $lang }}">
                        @endforeach
                    </div>
                    @error('languages')
                        <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                    @error('languages.*')
                        <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Acciones --}}
                <div class="flex items-center gap-5 mt-8">
                    <button type="submit" class="px-6 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                        Guardar cambios
                    </button>
                    <a href="{{ route('my-ads') }}" class="text-[14px] text-brand-text hover:text-brand-dark transition">Cancelar</a>
                </div>
            </div>

            {{-- ===== Columna derecha ===== --}}
            <div class="flex flex-col gap-6">

                {{-- Tarjeta de vista previa --}}
                <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-6 flex flex-col items-center text-center">
                    <div class="relative w-28 h-28 rounded-full overflow-hidden bg-brand-cream flex items-center justify-center" style="{{ $stripes }}" data-avatar-preview-wrap>
                        @if ($user->avatarUrl())
                            <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="absolute inset-0 w-full h-full object-cover" data-avatar-preview>
                        @else
                            <img src="" alt="" class="absolute inset-0 w-full h-full object-cover hidden" data-avatar-preview>
                            <span class="font-serif text-[28px] text-brand-sage-dark" data-avatar-initials>{{ $user->initials() }}</span>
                        @endif
                    </div>
                    <p class="font-serif text-[22px] tracking-tight mt-5">{{ old('name', $user->name) }}</p>
                    <p class="text-[13px] text-brand-muted flex items-center gap-1 mt-2">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        @if (old('city', $user->city))
                            {{ old('city', $user->city) }} ·
                        @endif
                        desde {{ $user->created_at->translatedFormat('F Y') }}
                    </p>
                    <div class="flex items-center gap-2 mt-4">
                        <span class="font-serif text-[18px] font-medium">4.9 ★</span>
                        <span class="text-[13px] text-brand-muted">142 reseñas</span>
                    </div>
                    <input type="file" name="avatar" accept="image/jpeg,image/jpg,image/png,image/webp" class="sr-only" data-avatar-input>
                    <button type="button" data-avatar-trigger class="inline-flex items-center gap-2 px-4 py-2.5 mt-5 rounded-full border border-brand-dark/15 text-[13px] font-medium text-brand-dark hover:bg-brand-sage-soft/40 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Cambiar foto
                    </button>
                    @error('avatar')
                        <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tarjeta de certificaciones (visual) --}}
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
    </form>

    <script>
        (function () {
            const langInputs = document.querySelector('[data-lang-inputs]');
            const langButtons = document.querySelectorAll('[data-lang]');

            function syncLanguages() {
                const selected = [...document.querySelectorAll('[data-lang]')]
                    .filter(el => el.dataset.state === 'on')
                    .map(el => el.dataset.value);

                langInputs.innerHTML = '';
                selected.forEach(value => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'languages[]';
                    input.value = value;
                    langInputs.appendChild(input);
                });
            }

            langButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const active = btn.dataset.state === 'on';
                    btn.dataset.state = active ? 'off' : 'on';

                    const check = btn.querySelector('[data-lang-check]');
                    if (active) {
                        btn.classList.remove('bg-brand-dark', 'text-brand-cream');
                        btn.classList.add('border', 'border-brand-dark/15', 'text-brand-text', 'hover:bg-brand-sage-soft/40');
                        check?.classList.add('hidden');
                    } else {
                        btn.classList.add('bg-brand-dark', 'text-brand-cream');
                        btn.classList.remove('border', 'border-brand-dark/15', 'text-brand-text', 'hover:bg-brand-sage-soft/40');
                        check?.classList.remove('hidden');
                    }

                    syncLanguages();
                });
            });

            const bioInput = document.querySelector('[data-bio-input]');
            const bioCount = document.querySelector('[data-bio-count]');
            if (bioInput && bioCount) {
                bioInput.addEventListener('input', () => {
                    bioCount.textContent = bioInput.value.length + '/300';
                });
            }

            const avatarInput = document.querySelector('[data-avatar-input]');
            const avatarTrigger = document.querySelector('[data-avatar-trigger]');
            const avatarPreview = document.querySelector('[data-avatar-preview]');
            const avatarInitials = document.querySelector('[data-avatar-initials]');

            avatarTrigger?.addEventListener('click', () => avatarInput?.click());

            avatarInput?.addEventListener('change', () => {
                const file = avatarInput.files?.[0];
                if (!file || !avatarPreview) return;

                const reader = new FileReader();
                reader.onload = e => {
                    avatarPreview.src = e.target.result;
                    avatarPreview.classList.remove('hidden');
                    avatarInitials?.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });
        })();
    </script>

</x-dashboard>
