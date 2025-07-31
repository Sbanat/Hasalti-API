<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BalanceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('balances')->insert([
            ['user_id' => 1, 'currency' => 'شيكل', 'amount' => 0],
            ['user_id' => 1, 'currency' => 'دولار', 'amount' => 0],
            ['user_id' => 1, 'currency' => 'دينار', 'amount' => 0],
        ]);
    }
}
