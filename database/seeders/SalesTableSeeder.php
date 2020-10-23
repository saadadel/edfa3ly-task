<?php

namespace Database\Seeders;

use App\Models\Sale;
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
        Sale::make([
            'id' => 1,
            'starts_at' => '23-10-2020',
            'ends_at' => '23-10-2022',
            'percentage' => 10.00
        ]);
    }
}
