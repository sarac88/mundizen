<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable([
    'name',
    'email',
    'password',
    'city',
    'phone',
    'website',
    'bio',
    'languages',
    'avatar_path',
])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'languages' => 'array',
        ];
    }

    public function avatarUrl(): ?string
    {
        if (! $this->avatar_path) {
            return null;
        }

        return Storage::disk('public')->url($this->avatar_path);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Ad::class, 'favorites')->withTimestamps();
    }

    public function receivedConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'owner_id');
    }

    public function sentConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(AppNotification::class);
    }

    public function unreadNotificationsCount(): int
    {
        return $this->appNotifications()->whereNull('read_at')->count();
    }

    public function unreadMessagesCount(): int
    {
        $asOwner = Message::query()
            ->whereHas('conversation', fn ($query) => $query->where('owner_id', $this->id))
            ->where('direction', Conversation::DIRECTION_CLIENT)
            ->whereNull('read_at')
            ->count();

        $asSender = Message::query()
            ->whereHas('conversation', fn ($query) => $query->where('sender_id', $this->id))
            ->where('direction', Conversation::DIRECTION_OWNER)
            ->whereNull('read_at')
            ->count();

        return $asOwner + $asSender;
    }
}
