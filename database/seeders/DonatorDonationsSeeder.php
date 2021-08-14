<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donator;
use App\Models\Donation;


class DonatorDonationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('donations')->delete();
        \DB::table('donators')->delete();

        Donator::factory(6)->create()->each(function($d) {
            $d->donations()
              ->saveMany(
                  Donation::factory(rand(1, 3))->make());
        });  
    }
}
