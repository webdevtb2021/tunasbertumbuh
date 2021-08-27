<?php

namespace Database\Factories;

use App\Models\Carousel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarouselFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carousel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => rtrim($this->faker->sentence(rand(5,10)),"."),
            'url_image' => $this->faker->image('public/storage/images/carousels/',800,600, null, true),
            'status' =>rand(0,1),
            'redirect_page' =>'home',
        ];
    }
}
