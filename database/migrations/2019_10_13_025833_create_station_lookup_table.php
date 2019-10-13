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
                $table->float('max_dockable_ship_volume');
                $table->string('name');
                $table->float('office_rental_cost');
                $table->bigInteger('owner')->nullable();
                $table->double('position_x');
                $table->double('position_y');
                $table->double('position_z');
                $table->bigInteger('race_id')->nullable();
                $table->float('reprocessing_efficiency');
                $table->float('reprocessing_stations_take');
                $table->string('services');
                $table->bigInteger('station_id');
                $table->bigInteger('system_id');
                $table->bigInteger('type_id');
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
