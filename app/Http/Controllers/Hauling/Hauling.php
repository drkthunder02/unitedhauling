<?php

namespace App\Http\Controllers\Hauling;

//Internal Library
use Illuminate\Http\Request;
use Carbon\Carbon;

//Libraries
use App\Library\Hauling\HaulingHelper;

//Models

class Hauling extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:Guest');
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
            'name1' => 'required',
            'name2' => 'required',
            'collateral' => 'required',
            'size' => 'required',
        ]);

        $size = $request->size;
        $collateral = $request->collateral;
        $time = '1 week';
        $duration = '3 days';

        $hHelper = new HaulingHelper;

        $jumps = $hHelper->JumpsBetweenSystems($request->name1, $request->name2);

        if($size > 0 && $size <= 57500) {
            $cost = $jumps * 750000;
        } else if($size > 57500 && $size < 800000) {
            $cost = $jumps * 1000000;
        } else {
            $cost = -1;
        }

        return  view('hauling.display.results')->with('jumps', $jumps)
                                               ->with('cost', $cost)
                                               ->with('collateral', $collateral)
                                               ->with('size', $size)
                                               ->with('time', $time)
                                               ->with('duration', $duration);
    }

    /**
     * Controller function to display quotes for pricing tables
     */
    public function displayQuotes() {
        return view('hauling.display.quotes');
    }
}
