<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('paypal_payments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paypal_payments');
    }
}
