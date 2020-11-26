<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['product_id','customer_name','customer_address','email','phone_no','note','order_status','purchase_type'];


     public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
