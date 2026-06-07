<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'user_id',
    'category',
    'title',
    'description',
    'certifications',
    'mode',
    'city',
    'address',
    'availability',
    'price_unit',
    'price',
    'duration',
    'status',
    'terms_accepted',
])]
class Ad extends Model
{
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'certifications' => 'array',
            'availability' => 'array',
            'price' => 'decimal:2',
            'terms_accepted' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(AdPhoto::class)->orderBy('sort_order');
    }

    public function mainPhoto(): HasOne
    {
        return $this->hasOne(AdPhoto::class)->orderBy('sort_order');
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PUBLISHED => 'Activo',
            self::STATUS_DRAFT => 'Borrador',
            default => ucfirst($this->status),
        };
    }

    public function modeLabel(): string
    {
        return match ($this->mode) {
            'presencial' => 'Presencial',
            'online' => 'Online',
            'domicilio' => 'A domicilio',
            default => $this->mode ?? '',
        };
    }

    public function formattedPrice(): string
    {
        if ($this->price === null) {
            return '—';
        }

        return number_format((float) $this->price, 0, ',', '.').' €';
    }
}
