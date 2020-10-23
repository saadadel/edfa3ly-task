<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'T-shirt',
                'price' => 10.99
            ],
            [
                'name' => 'Pants',
                'price' => 14.99
            ],
            [
                'name' => 'Jaket',
                'price' => 19.99
            ],
            [
                'name' => 'Shoes',
                'price' => 24.99
            ]
        ];

        foreach ($products as $product) {
            $product = Product::create([
                'name' => $product['name'],
                'price' => $product['price']
            ]);
            if($product->name == 'Shoes')
            {
                $product->sale_id = 1;
                $product->save();
            }
        }

    }
}
