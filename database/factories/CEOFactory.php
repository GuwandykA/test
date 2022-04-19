<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class CEOFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
        protected $model = User::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->realText(180),
            'price' => $this->faker->numberBetween(50, 100)
        ];
    }
      
    
}
