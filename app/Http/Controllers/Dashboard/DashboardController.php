<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

//Library
use App\Library\Contracts\ContractHelper;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('role:User');
    }

    public function index() {


        //Get the current amount of contracts availabe to the corporation for displaying on the dashboard with the relevant
        //information such as pickup and destination, jumps, and profit margin.

        return redirect('/');
    }

    public function profile() {
        return redirect('/');
    }
}
