<?php

namespace App\Http\Controllers\Hauling;

//Internal Library
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

//Libraries
use App\Library\Hauling\HaulingHelper;

//Models
use App\Models\Lookups\SolarSystem;
use App\Models\Config\HaulingConfig;

class HaulingController extends Controller
{
    public function __construct() {
        //
    }

    /**
     * Controller function to display form
     */
    public function displayForm() {
        if(Auth::check()) {
            return redirect('/dashboard');
        }

        return view('hauling.display.form');
    }

    /**
     * Controller function to display form results
     */
    public function displayFormResults(Request $request) {
        //Validate the request
        $this->validate($request, [
            'pickup' => 'required',
            'destination' => 'required',
            'collateral' => 'required',
            'size' => 'required|max:800000',
        ]);

        //Declare the class helper
        $hHelper = new HaulingHelper;

        //Declare some variables we will need
        $size = $request->size;
        $time = '1 week';
        $duration = '3 days';
        $pickup = $request->pickup;
        $destination = $request->destination;

        //Calculate the collateral
        if(preg_match('(m|M|b|B)', $request->collateral) === 1) {
            if(preg_match('(m|M)', $request->collateral) === 1) {
                $collateral = $request->collateral * 1000000.00;
            } else if(preg_match('(b|B)', $request->collaterial) === 1) {
                $collateral = $request->collateral * 1000000000.00;
            }
        } else {
            $collateral = $request->collateral;
        }

        //Get some configuration data for the haul
        $hConfig = HaulingConfig::all();
        

        //Determine if both systems are in high sec
        $system1 = SolarSystem::where(['name' => $pickup])->first();
        $system2 = SolarSystem::where(['name' => $destination])->first();

        if($system1->security_status < 0.5 || $system2->security_status < 0.5) {
            return redirect('/')->with('error', 'Both systems must be in high sec.');
        }

        //Calculate the jumps needed
        $jumps = $hHelper->JumpsBetweenSystems($pickup, $destination);

        //Calculte the cost based on jumps multiplied by the fee.
        foreach($hConfig as $config) {
            if($size > $config->min_load_size && $size <= $config->max_load_size) {
                $cost = $jumps * $hConfig->price_per_jump;
            }
        }

        return  view('hauling.display.results')->with('jumps', $jumps)
                                               ->with('cost', $cost)
                                               ->with('collateral', $collateral)
                                               ->with('size', $size)
                                               ->with('time', $time)
                                               ->with('duration', $duration)
                                               ->with('pickup', $pickup)
                                               ->with('destination', $destination);
    }

    /**
     * Controller function to display quotes for pricing tables
     */
    public function displayQuotes() {
        return view('hauling.display.quotes');
    }
}
