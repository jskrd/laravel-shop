<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketsTable extends Migration
{
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('discount_amount');
            $table->unsignedInteger('delivery_cost');
            $table->uuid('billing_address_id')->nullable();
            $table->uuid('delivery_address_id')->nullable();
            $table->uuid('discount_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('billing_address_id')
                ->references('id')
                ->on('addresses')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table
                ->foreign('delivery_address_id')
                ->references('id')
                ->on('addresses')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table
                ->foreign('discount_id')
                ->references('id')
                ->on('discounts')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('baskets');
    }
}
