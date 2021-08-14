<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => rtrim($this->faker->sentence(rand(5,10)),"."),
            'datetime' =>$this->faker->dateTimeBetween('+1 week', '+1 month'),
            'body' => $this->faker->paragraphs(rand(3,7),true),
            'user_id' =>User::all()->random()->id,
            'image' => $this->faker->image('public/storage/images/projects',400,200, null, false),

        ];
    }
}
