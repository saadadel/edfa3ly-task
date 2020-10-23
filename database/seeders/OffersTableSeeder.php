<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Offer::create([
            'buy_product' => 1, 
            'offer_product' => 3, 
            'buy_amount' => 2, 
            'offer_amount' => 1, 
            'offer_percentage' => 50.00
        ]);
    }
}
