<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class SeverityFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'color' => fake()->hexColor(),
        ];
    }

}
