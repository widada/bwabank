<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_types')->insert(
            [ 
                [
                    'name' => 'Transfer',
                    'code' => 'transfer',
                    'action' => 'dr',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Internet',
                    'code' => 'internet',
                    'action' => 'dr',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Top Up',
                    'code' => 'top_up',
                    'action' => 'cr',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Receive',
                    'code' => 'receive',
                    'action' => 'cr',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}