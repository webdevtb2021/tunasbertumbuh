<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\Donator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class DonationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category' => rand(1,2),
            'bukti' => $this->faker->image('public/storage/images/donations',400,200, null, false),
            'jenis_barang_or_jumlah_bayar' => rtrim($this->faker->sentence(rand(1,2)),"."),
            'notes' => rtrim($this->faker->sentence(rand(5,10)),"."),
            'address' =>$this->faker->address(),
            'verification'=>rand(0,1),
            'donator_id' => Donator::all()->random()->id,
            
        ];
    }
}
