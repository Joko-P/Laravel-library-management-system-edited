<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class studentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = FakerFactory::create('id_ID');

        $gender=['L','P'];
        $sex=['male','female'];
        $angka=random_int(0,1);
        return [
            'name' => $faker->name($sex[$angka]),
            'gender' => $gender[$angka],
            'email' => $this->faker->safeEmail,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'NIK' => $this->faker->numerify("################")
        ];
    }
}
