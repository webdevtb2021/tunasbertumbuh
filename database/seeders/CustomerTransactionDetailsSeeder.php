<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;


class CustomerTransactionDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('transaction_details')->delete();
        \DB::table('transactions')->delete();
        \DB::table('customers')->delete();

        Customer::factory(10)->create()->each(function($u) {
            $u->transactions()
              ->saveMany(
                  Transaction::factory(rand(1, 3))->make()
              )
              ->each(function ($a) {
                $a->transactionDetails()->saveMany(TransactionDetail::factory(rand(1, 3))->make());
              });
        });  
    }
}
