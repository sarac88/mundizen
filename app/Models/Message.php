<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'conversation_id',
    'direction',
    'body',
    'read_at',
])]
class Message extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function isFromClient(): bool
    {
        return $this->direction === Conversation::DIRECTION_CLIENT;
    }

    public function isFromOwner(): bool
    {
        return $this->direction === Conversation::DIRECTION_OWNER;
    }
}
