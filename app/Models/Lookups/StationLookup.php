<?php

namespace App\Models\Lookups;

use Illuminate\Database\Eloquent\Model;

class StationLookup extends Model
{
    //Table Name
    public $table = 'station_lookups';

    //Timestamps
    public $timestamps = true;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'max_dockable_ship_volume',
        'name',
        'office_rental_cost',
        'owner',
        'position_x',
        'position_y',
        'position_z',
        'race_id',
        'reprocessing_efficiency',
        'reprocessing_stations_take',
        'services',
        'station_id',
        'system_id',
        'type_id',
        'created_at',
        'updated_at',
    ];
}
