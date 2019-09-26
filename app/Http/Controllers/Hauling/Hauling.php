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
        ]);

        $hHelper = new HaulingHelper;

        $jumps = $hHelper->JumpsBetweenSystems($request->name1, $request->name2);

        return  view('hauling.display.results')->with('jumps', $jumps);
    }

    /**
     * Controller function to display quotes for pricing tables
     */
    public function displayQuotes() {
        return view('hauling.display.quotes');
    }
}
