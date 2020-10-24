<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriceTheCartTest extends TestCase
{
    // use RefreshDatabase;
    
    /**
     * test
     *
     * @return void
     */
    public function test_a_cart_can_price_products()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/cart', [
            'products' => ['T-shirt']
        ]);



        $response->assertStatus(200)
            ->assertJson([
                "Subtotal"=> "$10.99",
                "Taxes"=> "$1.5386",
                "Discounts"=> [],
                "Total"=> "$12.5286"
            ]);
    }

    /**
     * test
     *
     * @return void
     */
    public function test_a_cart_can_accept_mutlible_products()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/cart', [
            'products' => ['T-shirt', 'Jacket']
        ]);



        $response->assertStatus(200)
            ->assertJson([
                "Subtotal"=> "$30.98",
                "Taxes"=> "$4.3372",
                "Discounts"=> [],
                "Total"=> "$35.3172"
            ]);
    }

    /**
     * test
     *
     * @return void
     */
    public function test_a_cart_can_combine_offers()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/cart', [
            'products' => ['T-shirt', 'T-shirt', 'Shoes', 'Jacket']
        ]);



        $response->assertStatus(200)
            ->assertJson([
                "Subtotal"=> "$66.96",
                "Taxes"=> "$9.3744",
                "Discounts"=> [
                    "10% off Shoes : -$2.499",
                    "50% off Jacket : -$9.995"
                ],
                "Total"=> "$63.8404"
            ]);
    }

    /**
     * test
     *
     * @return void
     */
    public function test_a_bill_can_be_disblayed_in_various_currencies()
    {
        $this->withoutExceptionHandling();

        $response = $this
        ->withHeaders([
            'currency' => 'EGP',
        ])
        ->post('/api/cart', [
            'products' => ['T-shirt', 'Pants']
        ]);



        $response->assertStatus(200)
            ->assertJson([
                "Subtotal"=> "EGP408.02",
                "Taxes"=> "EGP57.1228",
                "Discounts"=> [],
                "Total"=> "EGP465.1428"
            ]);
    }
}
