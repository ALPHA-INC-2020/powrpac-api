<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->longText('note')->nullable();
            $table->enum('order_status', ['complete', 'confirm', 'cancel', 'inprogress', 'pending']);
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
