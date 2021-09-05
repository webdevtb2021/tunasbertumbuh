<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'image_payment' => $this->faker->image('public/storage/images/transactions',400,200, null, false),
            'total_transaction' => (rand(14,20)*10000),
            'notes' => $this->faker->sentence(rand(5,10)),
            'customer_id' => Customer::all()->random()->id,
            
        ];
    }
}
