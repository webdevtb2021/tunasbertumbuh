<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\Position;
use App\Models\Jabatan;
use App\Models\Periode;


class DivisionPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('positions')->delete();
        \DB::table('divisions')->delete();
        \DB::table('jabatans')->delete();
        \DB::table('periodes')->delete();


        Jabatan::create(['name'=>'Founder']);
        Jabatan::create(['name'=>'Director']);
        Jabatan::create(['name'=>'Manager']);
        Jabatan::create(['name'=>'Staff']);

        Periode::create(['name'=>'1.0']);
        Periode::create(['name'=>'2.0']);
        Periode::create(['name'=>'3.0']);

        Division::factory(10)->create()->each(function($d) {
            $d->positions()
              ->saveMany(
                  Position::factory(rand(4, 8))->make());
        });  
    }
}
