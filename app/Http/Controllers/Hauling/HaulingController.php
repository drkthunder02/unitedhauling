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
            'size' => 'required',
        ]);

        //Declare the class helper
        $hHelper = new HaulingHelper;

        //Declare some variables we will need
        $size = $request->size;
        $collateral = $request->collateral;
        $time = '1 week';
        $duration = '3 days';
        $pickup = $request->pickup;
        $destination = $request->destination;

        //Determine if both systems are in high sec
        $system1 = SolarSystem::where(['name' => $pickup])->first();
        $system2 = SolarSystem::where(['name' => $destination])->first();

        if($system1->security_status < 0.5 || $system2->security_status < 0.5) {
            return redirect('/')->with('error', 'Both systems must be in high sec.');
        }

        //Calculate the jumps needed
        $jumps = $hHelper->JumpsBetweenSystems($pickup, $destination);

        //Calculate the cost based on jumps multiplied by the fee.
        if($size > 0 && $size <= 8000) {
            $cost = $jumps * 600000;
        } else if($size > 8000 && $size <= 57500) {
            $cost = $jumps * 800000;
        } else if($size > 57500 && $size <= 800000) {
            $cost = $jumps * 1000000;
        } else {
            return redirect('/')->with('error', 'Size cannot be greater than 800k m3.');
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
