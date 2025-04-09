<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'key' => $this->faker->unique()->word(),
            'value' => $this->faker->sentence(),
            'locale' => $this->faker->randomElement(['en', 'fr', 'es']),
            'tag' => $this->faker->randomElement(['web', 'mobile', 'desktop']),
        ];
    }
}
