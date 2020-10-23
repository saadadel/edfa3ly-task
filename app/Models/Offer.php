<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['buy_product', 'offer_product', 'buy_amount', 'offer_amount', 'offer_percentage'];

    public function buyProduct()
    {
        return $this->belongsTo(Product::class, 'buy_product');
    }

    public function offerProduct()
    {
        return $this->belongsTo(Product::class, 'offer_product');
    }
}
