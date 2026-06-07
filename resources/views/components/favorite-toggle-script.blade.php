<script>
    (function () {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        function setFavorited(btn, favorited) {
            btn.dataset.favorited = favorited ? '1' : '0';
            btn.setAttribute('aria-label', favorited ? 'Quitar de favoritos' : 'Guardar en favoritos');

            const outline = btn.querySelector('[data-favorite-icon-outline]');
            const filled = btn.querySelector('[data-favorite-icon-filled]');

            if (outline) outline.classList.toggle('hidden', favorited);
            if (filled) filled.classList.toggle('hidden', !favorited);

            const variant = btn.dataset.favoriteVariant || 'overlay';
            const isSidebar = variant === 'sidebar';

            if (favorited) {
                btn.classList.add('bg-brand-dark', 'text-brand-cream');
                btn.classList.remove('bg-white/90', 'text-brand-text', 'hover:text-brand-dark');
                if (isSidebar) {
                    btn.classList.add('border-brand-dark');
                }
            } else {
                btn.classList.remove('bg-brand-dark', 'text-brand-cream', 'border-brand-dark');
                if (!isSidebar) {
                    btn.classList.add('bg-white/90', 'text-brand-text', 'hover:text-brand-dark');
                }
            }
        }

        function updateCount(delta) {
            const counter = document.querySelector('[data-favorites-count]');
            if (!counter) return;
            const current = parseInt(counter.textContent, 10) || 0;
            counter.textContent = String(Math.max(0, current + delta));
        }

        document.addEventListener('click', async (event) => {
            const btn = event.target.closest('[data-favorite-toggle]');
            if (!btn || btn.disabled) return;

            event.preventDefault();
            event.stopPropagation();

            btn.disabled = true;

            try {
                const response = await fetch(btn.dataset.url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (response.status === 401 || response.status === 419) {
                    window.location.href = '{{ route('login') }}';
                    return;
                }

                if (!response.ok) throw new Error('toggle failed');

                const data = await response.json();
                const wasFavorited = btn.dataset.favorited === '1';
                setFavorited(btn, data.favorited);

                const card = btn.closest('[data-favorite-card]');
                if (card && !data.favorited) {
                    card.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        card.remove();
                        updateCount(-1);

                        const grid = document.querySelector('[data-favorites-grid]');
                        if (grid && grid.children.length === 0) {
                            window.location.reload();
                        }
                    }, 200);
                } else if (!wasFavorited && data.favorited) {
                    updateCount(1);
                }
            } catch (error) {
                console.error(error);
            } finally {
                btn.disabled = false;
            }
        });
    })();
</script>
