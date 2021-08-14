<?php

namespace Database\Factories;

use App\Models\Partnership;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnershipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partnership::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'image' => $this->faker->image('public/storage/images/partnerships',400,200, null, false),
            'url' =>'https://instagram.com',
            'category' => rand(1,2),
            'notes' => $this->faker->sentence(rand(5,10)),
            
        ];
    }
}
