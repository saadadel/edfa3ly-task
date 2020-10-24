<?php


namespace App\Http\Controllers\Traits;

use App\Models\Tax;
use App\Models\Product;

trait ReceiptCalculator{

    private function getReceiptDetails($products)
    {
        // combine products with its amounts
        $products_with_count = array_count_values($products);

        $subtotal = $this->productsSubtotal($products_with_count);
        $taxes = $subtotal * (Tax::where('title', 'Value added tax')->first()->percentage / 100);
        $total = $subtotal + $taxes;
        $sales = $this->getSales($products_with_count, $total);
        $offers = $this->getOffers($products_with_count, $total);

        $symbol = currencySymbole(request()->header('currency', 'USD'));

        return [
            'Subtotal' => $symbol . $subtotal,
            'Taxes' => $symbol . $taxes,
            'Discounts' => array_merge($sales, $offers),
            'Total' => $symbol . $total,
        ];
    }

    private function productsSubtotal($products)
    {
        $sum = 0;

        foreach ($products as $name => $amount) {
            $sum += Product::where('name', $name)->first()->price * $amount;
        }

        return $sum;
    }

    private function getSales($products, &$total)
    {
        $sales = [];
        $symbol = currencySymbole(request()->header('currency', 'USD'));

        foreach ($products as $name => $amount) {
            $product = Product::where('name', $name)->first();
            if($product->sale)
            {
                for ($i=0; $i < $amount; $i++) { 
                    $sales[] = $product->sale->percentage . '% off ' . $product->name . ' : -' . $symbol . ($product->sale->percentage / 100) * $product->price;
                    
                    $total -= ($product->sale->percentage / 100) * $product->price;
                }
            }
        }

        return $sales;
    }

    private function getOffers($products, &$total)
    {
        $offers = [];
        $symbol = currencySymbole(request()->header('currency', 'USD'));

        foreach ($products as $name => $amount) {
            $product = Product::where('name', $name)->first();

            // get offers for this product only if the customer bought the min amount of the offer
            $product_offers = $product->buyProductOffer()->where('buy_amount', '<=', $amount)->get();

            //Check if this product have offers
            for ($i=0; $i < $product_offers->count(); $i++) { 
                $offer = $product_offers[$i];
                // check if the cart have the product to give the offer sale on
                if(array_key_exists($offer->offerProduct->name, $products))
                {
                    // to handle if the user cart can use the offer more than one time
                    // e.g. bought 4 T-shirts so he gets 2 jackets
                    $offer_using_number = floor( $amount / $offer->buy_amount );
                    $bought_product_number = $products[$offer->offerProduct->name];
                    for ($i=0; $i < $offer_using_number && $i < $bought_product_number; $i++) { 
                        $offers[] = $offer->offer_percentage . '% off ' . $offer->offerProduct->name . ' : -' . $symbol . ($offer->offer_percentage / 100) * $offer->offerProduct->price;

                        $total -= ($offer->offer_percentage / 100) * $offer->offerProduct->price;
                    }
                }
            }
        }

        return $offers;
    }
}
