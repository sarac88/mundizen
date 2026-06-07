@php
    $badge = [
        'published' => ['pill' => 'bg-brand-sage/15 text-brand-sage-dark', 'dot' => 'bg-brand-sage', 'label' => 'Activo'],
        'draft' => ['pill' => 'bg-neutral-200 text-neutral-600', 'dot' => 'bg-neutral-400', 'label' => 'Borrador'],
    ];

    $activeCount = $ads->where('status', 'published')->count();
    $draftCount = $ads->where('status', 'draft')->count();
@endphp

<x-dashboard title="Mis anuncios" active="anuncios">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-7">
        <div>
            <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">PANEL · MIS ANUNCIOS —</p>
            <h1 class="font-serif font-normal text-4xl lg:text-[40px] tracking-tight">
                Hola {{ auth()->user()->name }}, <span class="italic text-brand-sage">esto está vivo.</span>
            </h1>
        </div>
        <a href="{{ route('post-ad') }}" class="shrink-0 inline-flex items-center gap-2 px-5 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Pon un nuevo anuncio
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-brand-sage/30 bg-brand-sage-soft px-5 py-4 text-[14px] text-brand-sage-dark">
            {{ session('status') }}
        </div>
    @endif

    {{-- Estadísticas --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['value' => (string) $activeCount, 'label' => 'ANUNCIOS ACTIVOS', 'note' => $activeCount > 0 ? 'Publicados' : 'Sin activos', 'noteColor' => 'text-brand-sage-dark'],
                ['value' => (string) $ads->count(), 'label' => 'TOTAL ANUNCIOS', 'note' => $draftCount.' borradores', 'noteColor' => 'text-brand-muted'],
                ['value' => '0', 'label' => 'VISITAS (30 DÍAS)', 'note' => 'Próximamente', 'noteColor' => 'text-brand-muted'],
                ['value' => '0', 'label' => 'MENSAJES', 'note' => 'Próximamente', 'noteColor' => 'text-brand-muted'],
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
            <button class="px-4 py-2 rounded-full text-[13px] text-brand-text hover:text-brand-dark transition">Borrador</button>
        </div>
        <p class="text-[13px] text-brand-muted">{{ $ads->count() }} anuncios</p>
    </div>

    {{-- Lista de anuncios --}}
    <div class="flex flex-col gap-4">
        @forelse ($ads as $ad)
            @php
                $status = $badge[$ad->status] ?? $badge['draft'];
                $photo = $ad->mainPhoto;
            @endphp
            <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-4 flex flex-col sm:flex-row gap-4">

                {{-- Foto --}}
                <div class="shrink-0 w-full sm:w-28 h-28 rounded-xl overflow-hidden bg-brand-sage-soft flex items-center justify-center text-[11px] text-brand-dark/40 text-center leading-tight">
                    @if ($photo)
                        <img src="{{ $photo->url }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                    @else
                        [ sin foto ·<br>{{ strtolower($ad->modeLabel()) }} ]
                    @endif
                </div>

                {{-- Centro --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 text-[12px] text-brand-muted mb-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $status['pill'] }} font-medium">
                            <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>
                            {{ $status['label'] }}
                        </span>
                        <span>{{ $ad->created_at->diffForHumans() }}</span>
                        @if ($ad->mode)
                            <span>·</span>
                            <span>{{ $ad->modeLabel() }}</span>
                        @endif
                        @if ($ad->city)
                            <span>·</span>
                            <span>{{ $ad->city }}</span>
                        @endif
                    </div>

                    <h3 class="font-serif text-[20px] tracking-tight mb-3">{{ $ad->title }}</h3>

                    <div class="flex items-center gap-5 text-[13px] text-brand-muted">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            0
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            0
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                            </svg>
                            0 mensajes
                        </span>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="shrink-0 flex sm:flex-col items-end justify-between gap-3 sm:text-right">
                    <button class="px-4 py-2 rounded-full border border-brand-dark/15 text-[13px] font-medium text-brand-dark hover:bg-brand-sage-soft/50 transition" disabled>
                        {{ $ad->isPublished() ? 'Pausar' : 'Publicar' }}
                    </button>

                    <div class="flex flex-col items-end gap-2">
                        <p class="font-serif text-[18px] font-medium">{{ $ad->formattedPrice() }}</p>
                        <div class="flex items-center gap-3">
                            <button class="flex items-center gap-1.5 text-[13px] text-brand-text hover:text-brand-dark transition" disabled>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                </svg>
                                Editar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] p-10 text-center">
                <p class="font-serif text-[24px] tracking-tight mb-2">Aún no tienes anuncios</p>
                <p class="text-[14px] text-brand-text mb-6">Publica tu primera oferta y empieza a recibir contactos.</p>
                <a href="{{ route('post-ad') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                    Pon tu primer anuncio
                </a>
            </div>
        @endforelse
    </div>

</x-dashboard>
