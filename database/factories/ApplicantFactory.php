<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApplicantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Applicant::class;

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
            'scores' => rand(60,100),
            'ipk' => rand(2,4)/10,            
            'education' => $this->faker->paragraphs(rand(2,5),true),
            'biography' => $this->faker->paragraphs(rand(2,5),true),
            'summary' => $this->faker->paragraphs(rand(2,5),true),
            'other_notes' => $this->faker->paragraphs(rand(2,5),true),
            'application_id' => Application::all()->random()->id,

        ];
    }
}
