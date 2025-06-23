<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Use words() with the second parameter true to generate a title with only letters and spaces
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'ingredients' => $this->faker->words(5), 
            'steps' => $this->faker->sentences(3),
            'category_id' => $this->faker->numberBetween(1, 4), // Assuming 4 categories
            'user_id' => \App\Models\User::factory(), // links to a user
        ];
    }
    
}
