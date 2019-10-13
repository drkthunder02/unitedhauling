<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationLookupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('station_lookup')) {
            Schema::create('station_lookup', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('max_dockable_ship_volume');
                $table->string('name');
                $table->bigInteger('office_rental_cost');
                $table->bigInteger('owner')->nullable();
                $table->bigInteger('position_x');
                $table->bigInteger('position_y');
                $table->bigInteger('position_z');
                $table->unsignedBigInteger('race_id')->nullable();
                $table->decimal('reprocessing_efficiency');
                $table->decimal('reprocessing_stations_take');
                $table->string('services');
                $table->unsignedBigInteger('station_id');
                $table->unsignedBigInteger('system_id');
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
        Schema::dropIfExists('station_lookup');
    }
}
