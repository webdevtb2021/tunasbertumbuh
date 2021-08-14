<?php

namespace Database\Factories;

use App\Models\Volunteer;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VolunteerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Volunteer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'image' => $this->faker->image('public/storage/images/volunteers',400,400, null, false),
            'url' =>'https://instagram.com',
            'status' => rand(0,1),
            'notes' => $this->faker->sentence(rand(5,10)),
            'project_id' =>Project::all()->random()->id,
        ];
    }
}
