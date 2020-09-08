<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripePaymentIntentsTable extends Migration
{
    public function up()
    {
        Schema::create('stripe_payment_intents', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stripe_payment_intents');
    }
}
