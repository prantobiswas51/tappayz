<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->creditCardNumber(),
            'expiryDate' => fake()->creditCardExpirationDateString(),
            'cvv' => fake()->randomNumber(3, true),
            'vcc_id' => fake()->randomNumber(8, true),
            'organization' => fake()->randomElement(['Visa', 'Mastercard']),
            'state' => fake()->randomElement(['Active', 'Frozen', 'Terminated']),
            'email' => fake()->email(),
            'cardBalance' => fake()->randomFloat(2, 0, 1000),
            'bin' => fake()->randomNumber(6, true),
            'binId' => fake()->randomNumber(4, true),
            'remark' => fake()->sentence(),
            'createTime' => fake()->dateTimeBetween('-1 year'),
            'modifyTime' => fake()->dateTimeBetween('-6 months'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => 'Active',
        ]);
    }

    public function frozen(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => 'Frozen',
        ]);
    }

    public function terminated(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => 'Terminated',
        ]);
    }
}
