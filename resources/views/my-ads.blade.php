@php
    $listings = [
        [
            'title'     => 'Masaje sueco de 60 min en estudio céntrico',
            'status'    => 'Activo',
            'published' => 'Publicado hace 12 días',
            'mode'      => 'Presencial',
            'views'     => '1280',
            'likes'     => '42',
            'messages'  => '8 mensajes',
            'price'     => '45 €',
            'photo'     => 'bg-brand-sage-soft',
        ],
        [
            'title'     => 'Aromaterapia + masaje relajante (90 min)',
            'status'    => 'Activo',
            'published' => 'Publicado hace 3 semanas',
            'mode'      => 'Presencial',
            'views'     => '940',
            'likes'     => '36',
            'messages'  => '5 mensajes',
            'price'     => '70 €',
            'photo'     => 'bg-brand-sand',
        ],
        [
            'title'     => 'Sesión online de respiración consciente',
            'status'    => 'Pausado',
            'published' => 'Publicado hace 2 meses',
            'mode'      => 'Online',
            'views'     => '312',
            'likes'     => '9',
            'messages'  => '1 mensajes',
            'price'     => '25 €',
            'photo'     => 'bg-brand-sky',
        ],
        [
            'title'     => 'Reflexología podal terapéutica',
            'status'    => 'Activo',
            'published' => 'Publicado hace 1 mes',
            'mode'      => 'Presencial',
            'views'     => '560',
            'likes'     => '21',
            'messages'  => '2 mensajes',
            'price'     => '40 €',
            'photo'     => 'bg-brand-coral',
        ],
    ];

    $badge = [
        'Activo'   => ['pill' => 'bg-brand-sage/15 text-brand-sage-dark', 'dot' => 'bg-brand-sage'],
        'Pausado'  => ['pill' => 'bg-amber-100 text-amber-700',           'dot' => 'bg-amber-500'],
        'Borrador' => ['pill' => 'bg-neutral-200 text-neutral-600',        'dot' => 'bg-neutral-400'],
    ];
@endphp

<x-dashboard title="Mis anuncios" active="anuncios">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-7">
        <div>
            <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">PANEL · MIS ANUNCIOS —</p>
            <h1 class="font-serif font-normal text-4xl lg:text-[40px] tracking-tight">
                Hola Marta, <span class="italic text-brand-sage">esto está vivo.</span>
            </h1>
        </div>
        <a href="#" class="shrink-0 inline-flex items-center gap-2 px-5 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Pon un nuevo anuncio
        </a>
    </div>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['value' => '2',    'label' => 'ANUNCIOS ACTIVOS', 'note' => '+1 esta semana', 'noteColor' => 'text-brand-sage-dark'],
                ['value' => '2532', 'label' => 'VISITAS (30 DÍAS)', 'note' => '+18%',           'noteColor' => 'text-brand-sage-dark'],
                ['value' => '87',   'label' => 'GUARDADOS',        'note' => '+6',             'noteColor' => 'text-brand-sage-dark'],
                ['value' => '14',   'label' => 'MENSAJES',         'note' => '3 sin leer',      'noteColor' => 'text-brand-muted'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-5">
                <p class="font-serif text-[34px] leading-none font-medium">{{ $stat['value'] }}</p>
                <p class="text-[11px] text-brand-muted tracking-wide mt-3">{{ $stat['label'] }}</p>
                <p class="text-[12px] {{ $stat['noteColor'] }} font-medium mt-1.5">{{ $stat['note'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Tabs --}}
    <div class="flex items-center justify-between mb-5">
        <div class="inline-flex items-center gap-1 bg-white rounded-full border border-brand-dark/5 p-1">
            <button class="px-4 py-2 rounded-full text-[13px] font-medium bg-brand-sage-soft text-brand-dark">Todos</button>
            <button class="px-4 py-2 rounded-full text-[13px] text-brand-text hover:text-brand-dark transition">Activo</button>
            <button class="px-4 py-2 rounded-full text-[13px] text-brand-text hover:text-brand-dark transition">Pausado</button>
            <button class="px-4 py-2 rounded-full text-[13px] text-brand-text hover:text-brand-dark transition">Borrador</button>
        </div>
        <p class="text-[13px] text-brand-muted">{{ count($listings) }} anuncios</p>
    </div>

    {{-- Lista de anuncios --}}
    <div class="flex flex-col gap-4">
        @foreach ($listings as $item)
            <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-4 flex flex-col sm:flex-row gap-4">

                {{-- Foto --}}
                <div class="shrink-0 w-full sm:w-28 h-28 rounded-xl {{ $item['photo'] }} flex items-center justify-center text-[11px] text-brand-dark/40 text-center leading-tight">
                    [ foto ·<br>{{ strtolower($item['mode']) }} ]
                </div>

                {{-- Centro --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 text-[12px] text-brand-muted mb-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $badge[$item['status']]['pill'] }} font-medium">
                            <span class="w-1.5 h-1.5 rounded-full {{ $badge[$item['status']]['dot'] }}"></span>
                            {{ $item['status'] }}
                        </span>
                        <span>{{ $item['published'] }}</span>
                        <span>·</span>
                        <span>{{ $item['mode'] }}</span>
                    </div>

                    <h3 class="font-serif text-[20px] tracking-tight mb-3">{{ $item['title'] }}</h3>

                    <div class="flex items-center gap-5 text-[13px] text-brand-muted">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $item['views'] }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            {{ $item['likes'] }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                            </svg>
                            {{ $item['messages'] }}
                        </span>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="shrink-0 flex sm:flex-col items-end justify-between gap-3 sm:text-right">
                    @if ($item['status'] === 'Pausado')
                        <button class="px-4 py-2 rounded-full border border-brand-dark/15 text-[13px] font-medium text-brand-dark hover:bg-brand-sage-soft/50 transition">Reanudar</button>
                    @else
                        <button class="px-4 py-2 rounded-full border border-brand-dark/15 text-[13px] font-medium text-brand-dark hover:bg-brand-sage-soft/50 transition">Pausar</button>
                    @endif

                    <div class="flex flex-col items-end gap-2">
                        <p class="font-serif text-[18px] font-medium">{{ $item['price'] }}</p>
                        <div class="flex items-center gap-3">
                            <button class="flex items-center gap-1.5 text-[13px] text-brand-text hover:text-brand-dark transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                </svg>
                                Editar
                            </button>
                            <button class="flex items-center gap-1.5 text-[13px] text-red-500/80 hover:text-red-600 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                Borrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-dashboard>
