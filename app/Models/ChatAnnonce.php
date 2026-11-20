<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ChatAnnonce extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'listing_id', 'message'];

    public function listing(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
