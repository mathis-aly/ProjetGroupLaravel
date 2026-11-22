<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function secretRdvType(): string
    {
        return match ($this->slug) {
            'vehicules'  => 'Virée Nocturne & Évasion',
            'immobilier' => 'Suite Privée & Hôtel Particulier',
            'multimedia' => 'Club de Jazz & Nuit Électrique',
            'maison'     => 'Souper Clandestin à Huis Clos',
            'mode'       => 'Gala, Opéra & Soirée Habillée',
            'loisirs'    => 'Bar Clandestin & Grands Crus',
            'sport'      => 'Alchimie Intense & Sans Filtre',
            'livres'     => 'Salon Littéraire & Heure Tardive',
            default      => match (mb_strtolower($this->name)) {
                'véhicules', 'vehicules' => 'Virée Nocturne & Évasion',
                'immobilier'             => 'Suite Privée & Hôtel Particulier',
                'multimédia', 'multimedia' => 'Club de Jazz & Nuit Électrique',
                'maison'                 => 'Souper Clandestin à Huis Clos',
                'mode'                   => 'Gala, Opéra & Soirée Habillée',
                'loisirs'                => 'Bar Clandestin & Grands Crus',
                'sport'                  => 'Alchimie Intense & Sans Filtre',
                'livres'                 => 'Salon Littéraire & Heure Tardive',
                default                  => 'Rendez-vous Confidentiel',
            },
        };
    }

    public static function boot(): void
    {
        parent::boot();

        static::saved(function (Category $category) {
            Cache::forget('categories');
        });
        static::deleted(function (Category $category) {
            Cache::forget('categories');
        });
    }
}
