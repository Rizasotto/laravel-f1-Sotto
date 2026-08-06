<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model=Category::class;

    public function definition(): array
    {
        return [
            'category' => $this->faker->unique()->words(2, true), // English-like, no duplicates
            'description' => $this->faker->sentence(),
        ];
    }
}




