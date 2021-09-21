<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatorCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operator_cards')->insert([
            [
                'name' => 'Telkomsel',
                'status' => 'active',
                'thumbnail' => 'telkomsel.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Indosat',
                'status' => 'active',
                'thumbnail' => 'indosat.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Singtel',
                'status' => 'active',
                'thumbnail' => 'singtel.png',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
