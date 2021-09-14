<?php

namespace Database\Factories;

use App\Models\Dependence;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DependenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dependence::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'phone' =>$this->faker->phoneNumber(),
            'testimony' => $this->faker->sentence(rand(3,6)),
            'instagram' =>'https://instagram.com',
            'facebook' =>'https://facebook.com',
            'twitter' =>'https://twitter.com',
            'url_image' => $this->faker->image('public/storage/images/users',400,400, null, true),
        ];
    }
}
