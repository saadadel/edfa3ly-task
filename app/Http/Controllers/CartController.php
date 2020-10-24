<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ReceiptCalculator;
use App\Http\Requests\CartStoreRequest;
use App\Models\Tax;
use NumberFormatter;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ReceiptCalculator;

    public function store(CartStoreRequest $request)
    {
        return $this->getReceiptDetails($request->products);
    }
}
