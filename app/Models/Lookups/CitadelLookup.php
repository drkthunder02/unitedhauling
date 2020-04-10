<?php

namespace App\Models\Lookups;

use Illuminate\Database\Eloquent\Model;

class CitadelLookup extends Model
{
    //Table Name
    public $table = 'citadel_lookup';

    //Timestamps
    public $timestamps = true;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'structure_id',
        'name',
        'position_x',
        'position_y',
        'position_z',
        'solar_system_id',
        'type_id',
    ];
}
