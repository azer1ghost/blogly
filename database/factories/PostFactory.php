<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(25),
            'description' => $this->faker->realText(500),
            'user_id' => User::factory(),
            'publication_date' => now()->subDays(rand(1, 31)),
        ];
    }
}
