<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['model', 'productName', 'navigator', 'brand', 'rating', 'realPrice', 'promoPrice', 'type', 'productType', 'sale', 'details', 'imageURLs'];

    protected $casts = [
        'details' => 'array',
        'imageURLs' => 'array'
    ];
}
