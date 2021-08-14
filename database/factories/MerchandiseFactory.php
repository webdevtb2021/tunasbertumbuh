<?php

namespace Database\Factories;

use App\Models\Merchandise;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchandiseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Merchandise::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => rtrim($this->faker->sentence(rand(2,3)),"."),
            'image' => $this->faker->image('public/storage/images/merchandises',400,400, null, true),
            'description' => $this->faker->paragraphs(rand(2,3),true),
            'price' =>rand(1,3)*10000,
        ];
    }
}
