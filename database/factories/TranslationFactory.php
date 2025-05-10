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
    public function definition(): array
    {
        $locale = $this->faker->randomElement(['en_US', 'fr_FR', 'es_ES']);
        $faker = \Faker\Factory::create($locale);

        return [
            'locale' => substr($locale, 0, 2),  // 'en', 'fr', 'es'
            'key' => $this->faker->unique()->lexify('key_????????'),
            'content' => $faker->sentence,
            'tags' => $this->faker->randomElements(['mobile', 'web', 'desktop'], rand(1, 3)),
        ];
    }
}