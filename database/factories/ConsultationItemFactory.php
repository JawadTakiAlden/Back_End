<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConsultationItem>
 */
class ConsultationItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'expert_id' => fake()->numberBetween(1,200),
            'type_id' => fake()->numberBetween(1,5),
            'excerpt' => fake()->sentence,
            'body' => fake()->paragraph(2),
            'price' => fake()->numberBetween(40 , 80)
        ];
    }
}
