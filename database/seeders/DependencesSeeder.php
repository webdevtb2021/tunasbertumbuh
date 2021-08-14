<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dependence;

class DependencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('dependences')->delete();

        $users = User::pluck('id')->all();

        foreach ($users as $user)
        {
            Dependence::factory(1)->create(['user_id'=>$user]);
        }
    }
}
