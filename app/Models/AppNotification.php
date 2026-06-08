<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'type',
    'data',
    'read_at',
])]
class AppNotification extends Model
{
    public const TYPE_MESSAGE = 'message';

    public const TYPE_FAVORITE = 'favorite';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    public function actorName(): string
    {
        return $this->data['actor_name'] ?? 'Alguien';
    }

    public function adTitle(): ?string
    {
        return $this->data['ad_title'] ?? null;
    }

    public function targetUrl(): string
    {
        return $this->data['url'] ?? route('home');
    }

    public function messageText(): string
    {
        return match ($this->type) {
            self::TYPE_MESSAGE => "Nuevo mensaje de {$this->actorName()}",
            self::TYPE_FAVORITE => "A {$this->actorName()} le gusta tu anuncio «{$this->adTitle()}»",
            default => 'Nueva notificación',
        };
    }
}
