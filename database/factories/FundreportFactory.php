<?php

namespace Database\Factories;

use App\Models\Fundreport;
use Illuminate\Database\Eloquent\Factories\Factory;

class FundreportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fundreport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [       
            'notes' => $this->faker->sentence(rand(5,10)),
            'debit' => rand(10000,200000),
            'source' => rtrim($this->faker->sentence(rand(1,3)),"."), 
            'kredit' => rand(5000,300000),
            'saldo' => rand(50000,3000000),
            'date' =>$this->faker->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}
