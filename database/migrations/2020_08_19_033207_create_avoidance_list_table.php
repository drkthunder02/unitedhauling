<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvoidanceListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('avoidance_list')) {
            Schema::create('avoidance_list', function(Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('solar_system');
                $table->timestamps();
            });
        }

        DB::table('avoidance_list')->insert([
            'solar_system' => "Niarja",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avoidance_list');
    }
}
