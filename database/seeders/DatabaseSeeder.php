<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UserArticleImagesSeeder::class,
            DivisionPositionsSeeder::class,            
            ApplicationApplicantsSeeder::class,            
            DependencesSeeder::class,            
            ProjectVolunteersSeeder::class,
            PartnershipsSeeder::class,
            MerchandisesSeeder::class,
            CustomerTransactionDetailsSeeder::class,
            DonatorDonationsSeeder::class,
            FundreportsSeeder::class,
            PartnershipsSeeder::class,
            CarouselsSeeder::class,

        ]);    
    }
}
