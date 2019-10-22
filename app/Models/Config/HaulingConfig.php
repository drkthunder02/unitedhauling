<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class HaulingConfig extends Model
{
    //Table name
    protected $table = 'hauling_configuration';

    //Timestamps
    public $timestamps = true;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'load_size',
        'min_load_size',
        'max_load_size',
        'price_per_jump',
    ];
}
