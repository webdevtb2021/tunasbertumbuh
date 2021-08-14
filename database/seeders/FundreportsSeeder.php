<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fundreport;

class FundreportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('fundreports')->delete();

        Fundreport::factory(10)->create();
    }
}
