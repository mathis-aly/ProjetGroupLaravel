<?php

namespace App\Models;

use Database\Factories\UserFactory;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * Retrieve the user's secret Vesper profile data.
     *
     * @return array<string, mixed>
     */
    public function secretProfile(): array
    {
        $defaultPortraits = [
            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1000&q=85',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=1000&q=85',
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1000&q=85',
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=1000&q=85',
            'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1000&q=85',
            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=1000&q=85',
        ];

        $defaults = [
            'alias' => $this->name,
            'age' => 26 + (($this->id ?? 1) % 9),
            'gender' => (($this->id ?? 1) % 2 === 0) ? 'femme' : 'homme',
            'seeking' => 'tous',
            'district' => 'Quartier Saint-Étienne',
            'rdv_type' => 'Bar Clandestin & Grands Crus',
            'preferred_hour' => '22h30 • Souper aux Chandelles (Degré II)',
            'bio' => 'Esthète nocturne, sensible à l’élégance sobre, aux conversations qui s’étirent après minuit et aux secrets bien gardés.',
            'passphrase' => 'La montre retarde toujours à minuit.',
            'photo' => $defaultPortraits[($this->id ?? 0) % count($defaultPortraits)],
            'questionnaire_completed' => false,
            'is_verified' => false,
            'free_rdv_used' => false,
            'subscription_tier' => 'free',
        ];

        $path = storage_path('app/secret_profiles/user_' . $this->id . '.json');
        if (is_file($path)) {
            $saved = json_decode((string) file_get_contents($path), true);
            if (is_array($saved)) {
                return array_merge($defaults, array_filter($saved, fn ($v) => $v !== null && $v !== ''));
            }
        }

        return $defaults;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
