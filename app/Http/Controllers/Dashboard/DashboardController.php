<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Library
use App\Library\Contracts\ContractHelper;
use App\Library\Lookups\LookupHelper;
use App\Library\Esi\Esi;

//Models
use App\Models\Lookups\SolarSystem;
use App\Models\Lookups\SolarSystemDistance;
use App\Models\Lookups\StationLookup;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:User');
    }

    public function index() {
        //Declare the contract helper
        $contractHelper = new ContractHelper;
        $lookupHelper = new LookupHelper;
        $esiHelper = new Esi;

        //Declare array variable
        $contracts = array();
        $num = 0;

        //Get the current amount of contracts availabe to the corporation for displaying on the dashboard with the relevant
        //information such as pickup and destination, jumps, and profit margin.
        $tempContracts = $contractHelper->GetContracts(98615428);

        foreach($tempContracts as $con) {
            if($con->status == 'outstanding') {

                //Find the details on the starting location
                if($con->start_location_id < 100000000) {
                    $startStation = $lookupHelper->GetStationDetails($con->start_location_id);
                } else if($con->start_location_id >= 100000000) {
                    $startStation = $lookupHelper->GetCitadelDetails($con->start_location_id);
                } else {
                    $startStation = 'N/A';
                }

                //Find the details on the ending location
                if($con->end_location_id < 100000000) {
                    $endStation = $lookupHelper->GetStationDetails($con->end_location_id);
                } else if($con->end_location_id >= 100000000) {
                    $endStation = $lookupHelper->GetCitadelDetails($con->end_location_id);
                } else {
                    $endStation = 'N/A';
                }

                //Find the system via it's id.
                if(isset($startStation->system_id)) {
                    $startSystem = $lookupHelper->GetSolarSystemName($startStation->system_id);
                } else if(isset($startStation->solar_system_id)) {
                    $startSystem = $lookupHelper->GetSolarSystemName($startStation->solar_system_id);
                } else {
                    $startSystem = 'N/A';
                }

                //Find the system via it's id.
                if(isset($endStation->system_id)) {
                    $endSystem = $lookupHelper->GetSolarSystemName($endStation->system_id);
                } else if(isset($endStation->solar_system_id)) {
                    $endSystem = $lookupHelper->GetSolarSystemName($endStation->solar_system_id);
                } else {
                    $endSystem = 'N/A';
                }

                //Compile the final array
                $final = [
                    'pickup' => $startSystem,
                    'destination' => $endSystem,
                    'type' => $con->type,
                    'volume' => $con->volume,
                    'expired' => $esiHelper->DecodeDate($con->date_expired),
                    'collateral' => $con->collateral,
                    'reward' => $con->reward,
                    'availability' => $con->availability,
                ];

                array_push($contracts, $final);
                $num++;
            }
        }

        return view('dashboard.dashboard')->with('contracts', $contracts)
                                          ->with('num', $num);
    }

    public function profile() {
        $user = User::where(['character_id' => $this->user()->getId()])->first();

        return view('dashboard.profile')->with('user', $user);
    }
}
