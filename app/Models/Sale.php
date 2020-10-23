<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['starts_at', 'ends_at', 'percentage'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
