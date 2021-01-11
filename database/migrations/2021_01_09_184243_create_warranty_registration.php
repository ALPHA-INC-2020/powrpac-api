<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrantyRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranties', function (Blueprint $table) {
            $table->string('name');
            $table->string('birthday');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('township');
            $table->string('address');
            $table->string('start_buying_date');
            $table->string('purchase_from');
            $table->string('product_model_no');
            $table->string('product_serial_no');
            $table->string('warranty_card_img');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warranties');
    }
}
