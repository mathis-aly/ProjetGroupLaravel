<?php

namespace Database\Seeders;

use App\Models\{Category, Listing, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            'Véhicules', 'Immobilier', 'Multimédia', 'Maison',
            'Mode', 'Loisirs', 'Sport', 'Livres',
        ])->map(fn ($name) => Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]));

        $me = User::factory()->create(['email' => 'test@example.com']);
        $users = User::factory(10)->create()->push($me);

        Listing::factory(100)
            ->recycle($users)
            ->recycle($categories)
            ->create();
    }
}