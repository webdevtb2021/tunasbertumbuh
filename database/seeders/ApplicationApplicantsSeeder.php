<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Applicant;


class ApplicationApplicantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('applicants')->delete();
        \DB::table('applications')->delete();

        Application::factory(6)->create()->each(function($a) {
            $a->applicants()
              ->saveMany(
                  Applicant::factory(rand(5, 8))->make());
        });  
    }
}
