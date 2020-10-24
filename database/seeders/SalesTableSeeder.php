<?php

namespace Database\Seeders;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sale::create([
            'id' => 1,
            'starts_at' => Carbon::create(2020, 10, 23),
            'ends_at' => Carbon::create(2022, 10, 23),
            'percentage' => 10.00
        ]);
    }
}
