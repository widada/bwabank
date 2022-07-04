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
            AdminUserSeeder::class,
            DataPlanSeeder::class,
            OperatorCardSeeder::class,
            PaymentMethodSeeder::class,
            TransactionTypeSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
