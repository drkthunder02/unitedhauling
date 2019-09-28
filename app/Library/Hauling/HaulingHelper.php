<?php

namespace App\Library\Hauling;

//Internal Library
use Log;

//Library
use Seat\Eseye\Cache\NullCache;
use Seat\Eseye\Configuration;
use Seat\Eseye\Containers\EsiAuthentication;
use Seat\Eseye\Eseye;
use Seat\Eseye\Exceptions\RequestFailedException;

//Models
use App\Models\Lookups\SolarSystem;

class HaulingHelper {
    //Variables
    private $esi;

    //Constructor
    public function __construct() {
        $this->esi = new Eseye();
    }

    public function JumpsBetweenSystems($name1, $name2) {
        //Get the systems from the database
        $system1 = SolarSystem::where(['name' => $name1])->first();
        $system2 = SolarSystem::where(['name' => $name2])->first();

        try {
            $route = $this->esi->invoke('get', '/route/{origin}/{destination}/', [
                'origin' => $system1->solar_system_id,
                'destination' => $system2->solar_system_id,
            ])->setQueryString([
                'flag' => 'secure',
            ])->invoke();
        } catch(RequestFailedException $e) {
            return -1;
        }

        $length = sizeof($route);
        $length += 1;

        return $length;
    }
}

?>
