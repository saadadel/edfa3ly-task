<?php

namespace App\Models;

use Swap\Laravel\Facades\Swap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'sale_id'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function currenctSale()
    {
        return $this->sale()->where('starts_at', '<=', today())->where('ends_at', '>=', today());
    }

    public function buyProductOffer()
    {
        return $this->hasMany(Offer::class, 'buy_product');
    }

    public function offerPorductOffer()
    {
        return $this->hasMany(Offer::class, 'offer_product');
    }

    public function getPriceAttribute($price)
    {
        $currency = request()->header('currency', 'USD');
 
        if($currency != 'USD')
        {
            $rate = Swap::latest('USD/' . $currency);

            $price *= $rate->getValue();
        }

        $price = round((float) $price, 2);

        return $price;
    }
}
