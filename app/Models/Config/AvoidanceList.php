<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class AvoidanceList extends Model
{
    //Table Name
    protected $table = 'avoidance_list';

    //Timestamps
    public $timestamps = true;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'solar_system',
    ];
}
