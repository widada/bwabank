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
                    'code' => 'transfer',
                    'action' => 'dr',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'code' => 'purchase',
                    'action' => 'dr',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'code' => 'top_up',
                    'action' => 'cr',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'code' => 'receive',
                    'action' => 'cr',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}