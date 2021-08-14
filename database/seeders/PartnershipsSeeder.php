<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partnership;

class PartnershipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('partnerships')->delete();

        Partnership::factory(10)->create();
    }
}
