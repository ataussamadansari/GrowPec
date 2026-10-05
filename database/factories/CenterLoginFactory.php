<?php

namespace Database\Factories;

use App\Models\CenterLogin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CenterLogin>
 */
class CenterLoginFactory extends Factory
{
    protected $model = CenterLogin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true).' Center Login',
            'url' => fake()->url(),
            'is_active' => true,
            'index' => fake()->numberBetween(0, 50),
        ];
    }

    /**
     * Indicate that the center login is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
