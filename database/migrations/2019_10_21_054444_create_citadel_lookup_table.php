<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitadelLookupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('citadel_lookup')) {
            Schema::create('citadel_lookup', function(Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('structure_id');
                $table->string('name');
                $table->bigInteger('position_x');
                $table->bigInteger('position_y');
                $table->bigInteger('position_z');
                $table->unsignedBigInteger('solar_system_id');
                $table->unsignedBigInteger('type_id');
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
        Schema::dropIfExists('citadel_lookup');
    }
}
