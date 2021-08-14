<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Volunteer;


class ProjectVolunteersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('volunteers')->delete();
        \DB::table('projects')->delete();

        Project::factory(6)->create()->each(function($a) {
            $a->volunteers()
              ->saveMany(
                  Volunteer::factory(rand(5, 8))->make());
        });  
    }
}
