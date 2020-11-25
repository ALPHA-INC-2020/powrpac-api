<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('model')->unique();
            $table->string('productName');
            $table->string('navigator');
            $table->string('brand');
            $table->smallInteger('rating');
            $table->string('realPrice');
            $table->string('promoPrice');
            $table->string('type');
            $table->string('productType');
            $table->enum('sale', ['outstock', 'onsale', 'preorder']);
            $table->json('details');
            $table->json('imageURLs');
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
        Schema::dropIfExists('products');
    }
}
