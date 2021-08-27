<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\User;
use App\Models\Division;
use App\Models\Periode;
use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Position::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'leader' =>User::all()->random()->id,
            'division_id' =>Division::all()->random()->id,
            'user_id' =>User::all()->random()->id,
            'jabatan_id' => Jabatan::all()->random()->id,
            'periode_id' =>Periode::all()->random()->id,

        ];
    }
}
