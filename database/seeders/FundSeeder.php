<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fund_manager_id = DB::table('fund_managers')->insertGetId([
            'name' => fake()->name(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('funds')->insert([
            'name' => fake()->name(),
            'start_year' => fake()->year(),
            'fund_manager_id' => $fund_manager_id,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
