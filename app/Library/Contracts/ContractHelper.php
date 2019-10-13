<?php

namespace App\Library\Contracts;

//Internal Libraries
use DB;
use Log;

//Library
use Seat\Eseye\Cache\NullCache;
use Seat\Eseye\Configuration;
use Seat\Eseye\Containers\EsiAuthentication;
use Seat\Eseye\Eseye;
use Seat\Eseye\Exceptions\RequestFailedException;
use App\Library\Esi\Esi;

//Models
use App\Models\Esi\EsiScope;
use App\Models\Esi\EsiToken;

class ContractHelper {

    //Variables
    private $esi;

    //Construct
    public function __construct() {
        //Declare a helper variable we will need
        $esiHelper = new Esi;

        // Disable all caching for esi by setting teh NullCache as the
        // preferred cache handler.  By default Eseye will use the FileCache
        $configuration = Configuration::getInstance();
        $configuration->cache = NullCache::class;

        //Get the esi configuration from config files
        $config = config('esi');

        //Get the refresh token from the database
        $token = $esiHelper->GetRefreshToken($config['primary']);
        $this->esi = $esiHelper->SetupEsiAuthentication($token);
    }

    public function GetContracts($corpId) {
        $contracts = null;

        try {
            $contracts = $this->esi->invoke('get', '/corporations/{corporation_id}/contracts/', [
                'corporation_id' => $corpId,
            ]);
        } catch(RequestFailedException $e) {
            return null;
        }

        return $contracts;
    }
}

?>
