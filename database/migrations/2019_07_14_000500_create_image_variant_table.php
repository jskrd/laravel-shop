<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageVariantTable extends Migration
{
    public function up()
    {
        Schema::create('image_variant', function (Blueprint $table) {
            $table->uuid('image_id');
            $table->uuid('variant_id');
            $table->unsignedInteger('position');
            $table->timestamps();

            $table->primary(['image_id', 'variant_id']);

            $table
                ->foreign('image_id')
                ->references('id')
                ->on('images')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('variant_id')
                ->references('id')
                ->on('variants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('image_variant');
    }
}
