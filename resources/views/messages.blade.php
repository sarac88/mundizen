<x-dashboard title="Mensajes" active="mensajes">

  @php
      $viewer = auth()->user();
  @endphp

    {{-- Encabezado --}}
    <div class="mb-7">
        <p class="text-[11px] text-brand-sage font-medium tracking-[2px] mb-2">CONVERSACIONES —</p>
        <h1 class="font-serif font-normal text-4xl lg:text-[40px] tracking-tight">
            Tus <span class="italic text-brand-sage">conversaciones.</span>
        </h1>
    </div>

    @if (session('status'))
        <div class="mb-5 rounded-2xl border border-brand-sage/30 bg-brand-sage-soft/40 px-5 py-4 text-[14px] text-brand-sage-dark">
            {{ session('status') }}
        </div>
    @endif

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
                @forelse ($conversations as $conv)
                    @php
                        $isActive = $conversation && $conversation->id === $conv->id;
                        $preview = $conv->latestMessage?->body ?? '';
                        $time = $conv->last_message_at?->isToday()
                            ? $conv->last_message_at->format('H:i')
                            : ($conv->last_message_at?->isYesterday()
                                ? 'ayer'
                                : ($conv->last_message_at?->format('d M') ?? ''));
                    @endphp
                    <a href="{{ route('messages', $conv) }}" @class([
                        'flex gap-3 px-4 py-3.5 border-b border-brand-dark/5 transition',
                        'bg-brand-sage-soft/50' => $isActive,
                        'hover:bg-brand-sage-soft/25' => ! $isActive,
                    ])>
                        <div class="shrink-0 w-10 h-10 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[12px] font-semibold flex items-center justify-center">{{ $conv->counterpartInitials($viewer) }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[14px] font-medium leading-tight truncate">{{ $conv->counterpartName($viewer) }}</p>
                            <p class="text-[12px] text-brand-sage truncate mt-0.5">{{ $conv->ad->title }}</p>
                            <p class="text-[13px] text-brand-muted truncate mt-1">{{ Str::limit($preview, 50) }}</p>
                        </div>
                        <div class="shrink-0 flex flex-col items-end gap-2">
                            @if ($time)
                                <span class="text-[11px] text-brand-muted">{{ $time }}</span>
                            @endif
                            @if ($conv->unreadCountFor($viewer) > 0)
                                <span class="w-5 h-5 rounded-full bg-brand-sage text-brand-dark text-[11px] font-semibold flex items-center justify-center">{{ $conv->unreadCountFor($viewer) }}</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="p-6 text-center text-[14px] text-brand-muted">
                        Aún no tienes conversaciones.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ===== Chat ===== --}}
        <div class="flex flex-col overflow-hidden min-h-[520px]">
            @if ($conversation)
                {{-- Cabecera del chat --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-brand-dark/5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-brand-sage-soft text-brand-sage-dark text-[12px] font-semibold flex items-center justify-center">{{ $conversation->counterpartInitials($viewer) }}</div>
                        <div>
                            <p class="text-[15px] font-medium leading-tight">{{ $conversation->counterpartName($viewer) }}</p>
                            @if ($isViewerOwner && $conversation->isGuestConversation())
                                <p class="text-[12px] text-brand-muted mt-0.5">{{ $conversation->guest_email }}</p>
                            @endif
                            <p class="text-[12px] text-brand-muted mt-0.5">Sobre: <span class="italic">{{ $conversation->ad->title }}</span></p>
                        </div>
                    </div>
                    <a href="{{ route('listing', $conversation->ad) }}" class="w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition" aria-label="Ver anuncio">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                </div>

                {{-- Mensajes --}}
                <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                    @php
                        $currentDate = null;
                    @endphp
                    @foreach ($messages as $msg)
                        @php
                            $msgDate = $msg->created_at->isToday()
                                ? 'Hoy'
                                : ($msg->created_at->isYesterday()
                                    ? 'Ayer'
                                    : $msg->created_at->translatedFormat('d M Y'));
                            $isMine = ($isViewerOwner && $msg->isFromOwner()) || (! $isViewerOwner && $msg->isFromClient());
                        @endphp
                        @if ($currentDate !== $msgDate)
                            @php $currentDate = $msgDate; @endphp
                            <div class="flex items-center justify-center py-1">
                                <span class="text-[11px] text-brand-muted">— {{ $msgDate }} —</span>
                            </div>
                        @endif

                        @if ($isMine)
                            <div class="flex justify-end">
                                <div class="max-w-[78%] bg-brand-dark text-brand-cream rounded-2xl px-5 py-3.5">
                                    <p class="text-[14px] leading-relaxed">{{ $msg->body }}</p>
                                    <p class="text-[10px] text-brand-cream/50 mt-1.5">{{ $msg->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start">
                                <div class="max-w-[78%] bg-[#EDEBE4] text-brand-dark rounded-2xl px-5 py-3.5">
                                    <p class="text-[14px] leading-relaxed">{{ $msg->body }}</p>
                                    <p class="text-[10px] text-brand-muted mt-1.5">{{ $msg->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Respuesta --}}
                <div class="px-4 py-4 border-t border-brand-dark/5">
                    @if ($isViewerOwner && $conversation->isGuestConversation())
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <p class="text-[13px] text-brand-text leading-relaxed">
                                {{ $conversation->displayName() }} escribió sin cuenta. Responde por email para que reciba tu mensaje.
                            </p>
                            <a href="{{ $conversation->mailtoReplyUrl() }}" class="shrink-0 inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand-dark text-brand-cream rounded-full text-[14px] font-medium hover:opacity-90 transition">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                                Responder por email
                            </a>
                        </div>
                    @else
                        <form method="POST" action="{{ route('messages.reply', $conversation) }}" class="flex items-center gap-3">
                            @csrf
                            <input type="text" name="body" value="{{ old('body') }}" placeholder="Escribe un mensaje..." class="flex-1 px-4 py-3.5 rounded-xl border border-brand-dark/10 bg-transparent text-[14px] text-brand-dark placeholder:text-brand-muted focus:outline-none focus:border-brand-dark/20 @error('body') border-red-300 @enderror">
                            <button type="submit" class="shrink-0 w-12 h-12 rounded-xl bg-brand-dark text-brand-cream flex items-center justify-center hover:opacity-90 transition" aria-label="Enviar">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                            </button>
                        </form>
                        @error('body')
                            <p class="text-[13px] text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
            @else
                <div class="flex-1 flex items-center justify-center p-8 text-center">
                    <div>
                        <p class="font-serif text-[22px] tracking-tight text-brand-dark">Sin conversaciones</p>
                        <p class="text-[14px] text-brand-muted mt-2">Cuando escribas a un anuncio o te contacten, aparecerá aquí.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-dashboard>
