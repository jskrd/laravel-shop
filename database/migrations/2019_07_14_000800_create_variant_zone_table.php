<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantZoneTable extends Migration
{
    public function up()
    {
        Schema::create('variant_zone', function (Blueprint $table) {
            $table->uuid('variant_id');
            $table->uuid('zone_id');
            $table->unsignedInteger('delivery_cost');
            $table->timestamps();

            $table->primary(['zone_id', 'variant_id']);

            $table
                ->foreign('variant_id')
                ->references('id')
                ->on('variants')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('zone_id')
                ->references('id')
                ->on('zones')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('variant_zone');
    }
}
