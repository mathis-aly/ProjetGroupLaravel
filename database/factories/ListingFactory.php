<?php

namespace Database\Factories;

use App\Enums\ListingCondition;
use App\Models\{Category, User};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ListingFactory extends Factory
{
    public function definition(): array
    {
        $title = fake('fr_FR')->words(3, true);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => ucfirst($title),
            'slug' => Str::slug($title) . '-' . Str::lower(Str::random(6)),
            'description' => fake('fr_FR')->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 0, 1500),
            'city' => fake('fr_FR')->city(),
            'condition' => fake()->randomElement(ListingCondition::cases()),
        ];
    }

    public function sold(): static
    {
        return $this->state(['sold_at' => now()]);
    }
}