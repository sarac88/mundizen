@php
    $conversations = [
        [
            'initials' => 'CM',
            'name'     => 'Carlos M.',
            'time'     => '10:42',
            'subject'  => 'Masaje sueco de 60 min',
            'preview'  => 'Perfecto, te confirmo entonces …',
            'unread'   => '2',
            'active'   => true,
        ],
        [
            'initials' => 'AL',
            'name'     => 'Andrea L.',
            'time'     => 'ayer',
            'subject'  => 'Aromaterapia + masaje 90 min',
            'preview'  => 'Mil gracias, fue una pasada de sesión …',
            'unread'   => null,
            'active'   => false,
        ],
        [
            'initials' => 'JP',
            'name'     => 'Jordi P.',
            'time'     => 'lun',
            'subject'  => 'Pack 5 sesiones',
            'preview'  => '¿El pack se puede dividir con otr…',
            'unread'   => '1',
            'active'   => false,
        ],
        [
            'initials' => 'NT',
            'name'     => 'Noa T.',
            'time'     => '27 may',
            'subject'  => 'Sesión online de respiración',
            'preview'  => 'Te confirmo en cuanto pueda 🙏',
            'unread'   => null,
            'active'   => false,
        ],
    ];

    $messages = [
        ['from' => 'them', 'text' => 'Hola Marta, vi tu anuncio. ¿Tendrías hueco esta semana?', 'time' => '10:30'],
        ['from' => 'me',   'text' => '¡Hola Carlos! Sí, tengo libre el martes a las 18:30 o jueves a las 20:00.', 'time' => '10:36'],
        ['from' => 'them', 'text' => 'El martes me viene bien. ¿La cabina está cerca de Ruzafa?', 'time' => '10:40'],
        ['from' => 'me',   'text' => 'Sí, justo en c/ Cuba. Te paso la dirección exacta cuando confirmes.', 'time' => '10:41'],
        ['from' => 'them', 'text' => 'Perfecto, te confirmo entonces el martes.', 'time' => '10:42'],
    ];
@endphp

<x-dashboard title="Mensajes" active="mensajes">

    {{-- Encabezado --}}
    <div class="mb-7">
        <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">CONVERSACIONES —</p>
        <h1 class="font-serif font-normal text-4xl lg:text-[40px] tracking-tight">
            Mensajes de <span class="italic text-brand-sage">tus clientes.</span>
        </h1>
    </div>

    {{-- Card unificado: lista + chat --}}
    <div class="bg-white rounded-2xl border border-brand-dark/5 shadow-[0_8px_32px_rgba(42,61,54,0.04)] overflow-hidden grid grid-cols-1 lg:grid-cols-[340px_1fr] lg:h-[680px]">

        {{-- ===== Lista de conversaciones ===== --}}
        <div class="flex flex-col overflow-hidden border-b lg:border-b-0 lg:border-r border-brand-dark/5">
            {{-- Buscador --}}
            <div class="p-4 border-b border-brand-dark/5">
                <input type="text" placeholder="Buscar conversaciones..." class="w-full px-4 py-3 rounded-xl border border-brand-dark/10 bg-transparent text-[13px] text-brand-dark placeholder:text-brand-muted focus:outline-none focus:border-brand-dark/20">
            </div>

            {{-- Items --}}
            <div class="flex-1 overflow-y-auto">
                @foreach ($conversations as $conv)
                    <a href="#" @class([
                        'flex gap-3 px-4 py-3.5 border-b border-brand-dark/5 transition',
                        'bg-brand-sage-soft/50' => $conv['active'],
                        'hover:bg-brand-sage-soft/25' => ! $conv['active'],
                    ])>
                        <div class="shrink-0 w-10 h-10 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[12px] font-semibold flex items-center justify-center">{{ $conv['initials'] }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[14px] font-medium leading-tight truncate">{{ $conv['name'] }}</p>
                            <p class="text-[12px] text-brand-sage truncate mt-0.5">{{ $conv['subject'] }}</p>
                            <p class="text-[13px] text-brand-muted truncate mt-1">{{ $conv['preview'] }}</p>
                        </div>
                        <div class="shrink-0 flex flex-col items-end gap-2">
                            <span class="text-[11px] text-brand-muted">{{ $conv['time'] }}</span>
                            @if ($conv['unread'])
                                <span class="w-5 h-5 rounded-full bg-brand-sage text-brand-dark text-[11px] font-semibold flex items-center justify-center">{{ $conv['unread'] }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ===== Chat ===== --}}
        <div class="flex flex-col overflow-hidden min-h-[520px]">

            {{-- Cabecera del chat --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-brand-dark/5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[12px] font-semibold flex items-center justify-center">CM</div>
                    <div>
                        <p class="text-[15px] font-medium leading-tight">Carlos M.</p>
                        <p class="text-[12px] text-brand-muted mt-0.5">Sobre: <span class="italic">Masaje sueco de 60 min</span></p>
                    </div>
                </div>
                <button class="w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition" aria-label="Ver anuncio">
                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            {{-- Mensajes --}}
            <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                {{-- Separador de fecha --}}
                <div class="flex items-center justify-center py-1">
                    <span class="text-[11px] text-brand-muted">— Hoy —</span>
                </div>

                @foreach ($messages as $msg)
                    @if ($msg['from'] === 'me')
                        <div class="flex justify-end">
                            <div class="max-w-[78%] bg-brand-dark text-brand-cream rounded-2xl px-5 py-3.5">
                                <p class="text-[14px] leading-relaxed">{{ $msg['text'] }}</p>
                                <p class="text-[10px] text-brand-cream/50 mt-1.5">{{ $msg['time'] }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-start">
                            <div class="max-w-[78%] bg-[#EDEBE4] text-brand-dark rounded-2xl px-5 py-3.5">
                                <p class="text-[14px] leading-relaxed">{{ $msg['text'] }}</p>
                                <p class="text-[10px] text-brand-muted mt-1.5">{{ $msg['time'] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Caja de escritura --}}
            <div class="px-4 py-4 border-t border-brand-dark/5">
                <div class="flex items-center gap-3">
                    <input type="text" placeholder="Escribe un mensaje..." class="flex-1 px-4 py-3.5 rounded-xl border border-brand-dark/10 bg-transparent text-[14px] text-brand-dark placeholder:text-brand-muted focus:outline-none focus:border-brand-dark/20">
                    <button class="shrink-0 w-12 h-12 rounded-xl bg-brand-dark text-brand-cream flex items-center justify-center hover:opacity-90 transition" aria-label="Enviar">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

</x-dashboard>
