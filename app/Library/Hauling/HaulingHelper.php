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

    /**
     * Get the number of jumps between systems in order to feed to the calling function
     * 
     * @string $name1
     * @string $name2
     * @array $avoids
     * 
     * @return $length
     */
    public function JumpsBetweenSystems($name1, $name2, $avoids = null) {
        //Get the systems from the database
        $system1 = SolarSystem::where(['name' => $name1])->first();
        $system2 = SolarSystem::where(['name' => $name2])->first();
        $firstTime = true;

        //If avoids does not equal null, then cycle through them and build an array of avoid list
        if($avoids != null) {
            //Convert $avoids into a string fro the query string for ESI
            foreach($avoids as $avoid) {
                if($firstTime == true) {
                    $temp = SolarSystem::where(['name' => $avoid])->first();
                    $strAvoid = $temp->solar_system_id;
                    $firstTime = false;
                } else {
                    $temp = SolarSystem::where(['name' => $avoid])->first();
                    $strAvoid = $strAvoid . ',' . $temp->solar_system_id;
                }
            }

            try {
                $route = $this->esi->setQueryString([
                    'flag' => 'secure',
                    'avoid' => $strAvoid,
                ])->invoke('get', '/route/{origin}/{destination}/', [
                    'origin' => $system1->solar_system_id,
                    'destination' => $system2->solar_system_id,
                ]);
            } catch(RequestFailedException $e) {
                return -1;
            }

            //Set the length of the route
            $length = sizeof($route);

        //If no avoids, then continue as normal
        } else {
            try {
                $route = $this->esi->setQueryString([
                    'flag' => 'secure',
                ])->invoke('get', '/route/{origin}/{destination}/', [
                    'origin' => $system1->solar_system_id,
                    'destination' => $system2->solar_system_id,
                ]);
            } catch(RequestFailedException $e) {
                return -1;
            }
    
            $length = sizeof($route);
        }

        return $length;
    }
}

?>
