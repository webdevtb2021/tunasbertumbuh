<?php

namespace Database\Factories;

use App\Models\Donator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DonatorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donator::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->name(),
            'phone' =>$this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' =>$this->faker->address(),
        ];
    }
}
