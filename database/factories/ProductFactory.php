<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return (function () {
            $vendorId = \App\Models\Vendor::inRandomOrder()->value('id');

            return [
                'vendor_id'     => $vendorId,
                'name'          => $this->faker->words(2, true),
                'price'         => $this->faker->randomFloat(2, 10, 500),
                'stock'         => $this->faker->numberBetween(0, 200),
                'description'   => $this->faker->text(200),
            ];
        })();
    }
}
