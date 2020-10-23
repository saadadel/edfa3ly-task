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
        return $this->belongsTo(Sale::class);
    }

    public function currenctSale()
    {
        return $this->sale()->where('starts_at', '<=', today())->where('ends_at', '>=', today());
    }

    public function getPriceAttribute($price)
    {
        $currency = app('request')->header('currency', 'USD');
 
        if($currency->code != 'USD')
        {
            $rate = Swap::latest('USD/' . $currency->code);

            $price *= $rate->getValue();
        }

        $price = round((float) $price, 2);

        return $price;
    }
}
