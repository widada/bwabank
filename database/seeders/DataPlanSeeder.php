<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_plans')->insert([
            [
                'name' => '10 GB',
                'price' => 100000,
                'operator_card_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '25 GB',
                'price' => 200000,
                'operator_card_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '40 GB',
                'price' => 300000,
                'operator_card_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '60 GB',
                'price' => 400000,
                'operator_card_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '10 GB',
                'price' => 100000,
                'operator_card_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '25 GB',
                'price' => 200000,
                'operator_card_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '40 GB',
                'price' => 300000,
                'operator_card_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '60 GB',
                'price' => 400000,
                'operator_card_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '10 GB',
                'price' => 100000,
                'operator_card_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '25 GB',
                'price' => 200000,
                'operator_card_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '40 GB',
                'price' => 300000,
                'operator_card_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '60 GB',
                'price' => 400000,
                'operator_card_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
