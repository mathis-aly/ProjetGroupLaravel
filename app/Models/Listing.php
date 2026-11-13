<?php

namespace App\Models;

use App\Enums\ListingCondition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
