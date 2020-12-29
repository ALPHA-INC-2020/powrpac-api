<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['model', 'productName', 'navigator', 'brand', 'rating', 'realPrice', 'promoPrice', 'type', 'productType', 'sale', 'details', 'imageURLs', 'isNewRelease', 'isPopular'];

    protected $casts = [
        'details' => 'array',
        'imageURLs' => 'array',
    ];

    public function order()
    {
        return $this->hasOne('App\Order');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
