<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageProductTable extends Migration
{
    public function up()
    {
        Schema::create('image_product', function (Blueprint $table) {
            $table->uuid('image_id');
            $table->uuid('product_id');
            $table->unsignedInteger('position');
            $table->timestamps();

            $table->primary(['image_id', 'product_id']);

            $table
                ->foreign('image_id')
                ->references('id')
                ->on('images')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('image_product');
    }
}
