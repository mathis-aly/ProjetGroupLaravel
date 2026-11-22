<?php

namespace App\Models;

use App\Enums\ListingCondition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'slug', 'description',
        'price', 'city', 'condition', 'sold_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'condition' => ListingCondition::class,
            'sold_at' => 'datetime',
        ];
    }

    public function scopeAvailable(Builder $query): void
    {
        $query->whereNull('sold_at');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function secretRdvLabel(): string
    {
        if ($this->relationLoaded('category') && $this->category) {
            return $this->category->secretRdvType();
        }

        return $this->category?->secretRdvType() ?? 'Souper Clandestin & Grands Crus';
    }

    public function secretHourLabel(): string
    {
        $p = (float) $this->price;

        if ($p <= 50) {
            return '21h00 • Premier Verre Feutré';
        }
        if ($p <= 150) {
            return '22h30 • Souper aux Chandelles';
        }
        if ($p <= 400) {
            return '23h45 • Confidences de Minuit';
        }

        return '01h15 • Jusqu’à l’Aube';
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Listing $listing) {
            Cache::forget('home.latest');
        });
        static::deleted(function (Listing $listing) {
            Cache::forget('home.latest');
        });
    }
}
