<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

#[Fillable([
    'ad_id',
    'owner_id',
    'sender_id',
    'guest_name',
    'guest_email',
    'subject',
    'last_message_at',
])]
class Conversation extends Model
{
    public const DIRECTION_CLIENT = 'client';

    public const DIRECTION_OWNER = 'owner';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function displayName(): string
    {
        if ($this->sender) {
            return $this->sender->name;
        }

        return $this->guest_name ?? 'Cliente';
    }

    public function initials(): string
    {
        return Str::of($this->displayName())
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function isOwner(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    public function isSender(User $user): bool
    {
        return $this->sender_id === $user->id;
    }

    public function isParticipant(User $user): bool
    {
        return $this->isOwner($user) || $this->isSender($user);
    }

    public function unreadCountFor(User $user): int
    {
        $direction = $this->isOwner($user)
            ? self::DIRECTION_CLIENT
            : self::DIRECTION_OWNER;

        return $this->messages()
            ->where('direction', $direction)
            ->whereNull('read_at')
            ->count();
    }

    public function counterpartName(User $viewer): string
    {
        if ($this->isOwner($viewer)) {
            return $this->displayName();
        }

        return $this->owner?->name ?? 'Anunciante';
    }

    public function counterpartInitials(User $viewer): string
    {
        return Str::of($this->counterpartName($viewer))
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function incomingDirectionFor(User $user): string
    {
        return $this->isOwner($user)
            ? self::DIRECTION_CLIENT
            : self::DIRECTION_OWNER;
    }

    public function outgoingDirectionFor(User $user): string
    {
        return $this->isOwner($user)
            ? self::DIRECTION_OWNER
            : self::DIRECTION_CLIENT;
    }

    public function isGuestConversation(): bool
    {
        return $this->sender_id === null && filled($this->guest_email);
    }

    public function mailtoReplyUrl(): ?string
    {
        if (! $this->isGuestConversation()) {
            return null;
        }

        $subject = $this->subject ?? 'Re: '.$this->ad->title;

        return 'mailto:'.$this->guest_email.'?subject='.rawurlencode($subject);
    }
}
