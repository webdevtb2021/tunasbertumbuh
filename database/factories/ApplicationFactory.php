<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Division;
use App\Models\Jabatan;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'notes' => $this->faker->paragraphs(rand(2,5),true),
            'count' => rand(1,3),
            'datetime' =>$this->faker->dateTimeBetween('+1 week', '+1 month'),
            'division_id' =>Division::all()->random()->id,
            'jabatan_id' =>Jabatan::all()->random()->id,
            'periode_id' =>Periode::all()->random()->id,
        ];
    }
}
