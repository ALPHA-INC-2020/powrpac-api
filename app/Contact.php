<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $table = 'contact_msgs';
    protected $fillable = ['name','email','content','phone_number'];
}
