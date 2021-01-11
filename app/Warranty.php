<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{

    protected $table = 'warranties';
    
    protected $fillable = ['name', 'birthday', 'phone_number', 'email', 'township', 'address', 'start_buying_date', 'purchase_from', 'product_model_no', 'product_serial_no', 'warranty_card_img'];
}
