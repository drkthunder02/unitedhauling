<?php

namespace App\Http\Controllers\Dashboard;

//Internal Libraries
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Log;

//Models
use App\Models\Esi\EsiScope;
use App\Models\Esi\EsiToken;
use App\Models\User\UserPermission;
use App\Models\User\UserRole;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Guest');
    }

    /**
     * Create dashboard where user logs in
     * 
     * @return void 
     */
    public function index() {
        return view('dashboard.dashboard');
    }

    /**
     * Create profile for user
     * 
     * @return void
     */
    public function profile() {
        return view('dashboard.profile');
    }

}

?>
