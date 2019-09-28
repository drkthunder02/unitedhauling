<?php

namespace App\Http\Controllers\Hauling;

//Internal Library
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

//Libraries
use App\Library\Hauling\HaulingHelper;

//Models

class HaulingController extends Controller
{
    public function __construct() {
        //
    }

    /**
     * Controller function to display form
     */
    public function displayForm() {
        return view('hauling.display.form');
    }

    /**
     * Controller function to display form results
     */
    public function displayFormResults(Request $request) {
        $this->validate($request, [
            'pickup' => 'required',
            'destination' => 'required',
            'collateral' => 'required',
            'size' => 'required',
        ]);

        $size = $request->size;
        $collateral = $request->collateral;
        $time = '1 week';
        $duration = '3 days';
        $pickup = $request->pickup;
        $destination = $request->destination;

        $hHelper = new HaulingHelper;

        $jumps = $hHelper->JumpsBetweenSystems($pickup, $destination);

        if($size > 0 && $size <= 8000) {
            $cost = $jumps* 600000;
        } else if($size > 8000 && $size <= 57500) {
            $cost = $jumps * 750000;
        } else if($size > 57500 && $size <= 800000) {
            $cost = $jumps * 1000000;
        } else {
            $cost = -1;
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
