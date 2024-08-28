<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class bookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = ['male','female'];
        return [
            'name' => $this->faker->sentence(3).' by '.$this->faker->firstName($gender[random_int(0,1)]),
            'category_id' => random_int(1,25),
            'auther_id' => random_int(1,100),
            'publisher_id' => random_int(1,75),
            'in_stock' => random_int(1,5)
        ];
    }
}
