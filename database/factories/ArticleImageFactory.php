<?php

namespace Database\Factories;

use App\Models\ArticleImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ArticleImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url_image' => $this->faker->image('public/storage/images/articles',400,200, null, false),
        ];
    }
}
