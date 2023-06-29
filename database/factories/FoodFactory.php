<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;






/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rand = rand(1,50);

        return [
            'name' => $this->faker->unique()->name(),
            'price' => rand(1,100),
            'description' => $this->faker->sentence(),
            'excerpt' => $this->faker->paragraph(2),
            'status' => 1,
            // 'category_id' => Category::factory()->create()->id,
            'category_id' => rand(1,5),

            'type' => 1,
            'image' =>  "https://picsum.photos/800/500?".$rand,

        ];
    }
}