<?php

namespace Database\Factories;

use App\Models\Merchandise;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class TransactionDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransactionDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $count = rand(1,4);
        return [
            'merchandise_id' => Merchandise::all()->random()->id,
            'transaction_id' => Transaction::all()->random()->id,
            'count' => $count,
            'total' => $count * 10000,
        ];
    }
}
