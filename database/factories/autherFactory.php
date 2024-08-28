<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class autherFactory  extends Factory
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
            'name' => $this->faker->name($gender[random_int(0,1)])
        ];
    }
}
