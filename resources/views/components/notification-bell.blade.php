@php
    $user = auth()->user();
    $notifications = $user->appNotifications()->latest()->limit(10)->get();
    $unreadCount = $user->unreadNotificationsCount();
@endphp

<div class="relative" data-notification-bell>
    <button
        type="button"
        data-notification-toggle
        aria-label="Notificaciones"
        aria-expanded="false"
        class="relative w-9 h-9 rounded-full border border-brand-dark/10 flex items-center justify-center text-brand-text hover:text-brand-dark transition"
    >
        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @if ($unreadCount > 0)
            <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 rounded-full bg-brand-sage text-brand-dark text-[10px] font-semibold flex items-center justify-center ring-2 ring-brand-cream">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div
        data-notification-panel
        class="hidden absolute right-0 top-full mt-2 w-[320px] max-w-[calc(100vw-2rem)] bg-white rounded-2xl border border-brand-dark/5 shadow-[0_12px_40px_rgba(42,61,54,0.12)] z-50 overflow-hidden"
    >
        <div class="flex items-center justify-between px-4 py-3 border-b border-brand-dark/5">
            <p class="text-[14px] font-medium text-brand-dark">Notificaciones</p>
            @if ($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="text-[12px] text-brand-sage-dark hover:text-brand-dark transition">
                        Marcar todas como leídas
                    </button>
                </form>
            @endif
        </div>

        @if ($notifications->isEmpty())
            <div class="px-4 py-8 text-center">
                <p class="text-[13px] text-brand-muted">No tienes notificaciones todavía</p>
            </div>
        @else
            <ul class="max-h-[360px] overflow-y-auto divide-y divide-brand-dark/5">
                @foreach ($notifications as $notification)
                    <li @class([
                        'flex items-stretch',
                        'bg-brand-sage-soft/20' => $notification->isUnread(),
                    ])>
                        <form method="POST" action="{{ route('notifications.read', $notification) }}" class="flex-1 min-w-0">
                            @csrf
                            <button
                                type="submit"
                                class="w-full flex items-start gap-3 px-4 py-3 text-left hover:bg-brand-sage-soft/40 transition"
                            >
                                <span @class([
                                    'mt-0.5 w-8 h-8 rounded-full flex items-center justify-center shrink-0',
                                    'bg-brand-sage-soft text-brand-sage-dark' => $notification->type === \App\Models\AppNotification::TYPE_MESSAGE,
                                    'bg-rose-50 text-rose-500' => $notification->type === \App\Models\AppNotification::TYPE_FAVORITE,
                                ])>
                                    @if ($notification->type === \App\Models\AppNotification::TYPE_MESSAGE)
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                        </svg>
                                    @endif
                                </span>
                                <span class="flex-1 min-w-0">
                                    <span class="block text-[13px] text-brand-dark leading-snug">
                                        {{ $notification->messageText() }}
                                    </span>
                                    <span class="block text-[11px] text-brand-muted mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </span>
                                @if ($notification->isUnread())
                                    <span class="mt-2 w-2 h-2 rounded-full bg-brand-sage shrink-0"></span>
                                @endif
                            </button>
                        </form>
                        <form method="POST" action="{{ route('notifications.destroy', $notification) }}" class="shrink-0 flex items-center pr-3">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                aria-label="Eliminar notificación"
                                class="w-7 h-7 rounded-full flex items-center justify-center text-brand-muted hover:text-rose-500 hover:bg-rose-50 transition"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<script>
    (function () {
        document.querySelectorAll('[data-notification-bell]').forEach((root) => {
            const toggle = root.querySelector('[data-notification-toggle]');
            const panel = root.querySelector('[data-notification-panel]');

            if (!toggle || !panel) return;

            function close() {
                panel.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
            }

            function open() {
                panel.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'true');
            }

            toggle.addEventListener('click', (event) => {
                event.stopPropagation();
                const isOpen = !panel.classList.contains('hidden');
                if (isOpen) {
                    close();
                } else {
                    open();
                }
            });

            document.addEventListener('click', (event) => {
                if (!root.contains(event.target)) {
                    close();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    close();
                }
            });
        });
    })();
</script>
