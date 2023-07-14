<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LinkVisitLogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ip' => $this->faker->ipv4(),
            'link_id' => $this->faker->numberBetween(1, 183),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
