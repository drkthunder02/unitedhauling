<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHualingConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('hauling_configuration')) {
            Schema::create('hauling_configuration', function (Blueprint $table) {
                $table->increments('id');
                $table->string('load_size')->unique();
                $table->unsignedBigInteger('min_load_size');
                $table->ungiendBigInteger('max_load_size');
                $table->decimal('price_per_jump');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hualing_config');
    }
}
