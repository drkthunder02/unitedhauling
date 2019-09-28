<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('role:Uesr');
    }

    public function index() {
        return redirect('/');
    }

    public function profile() {
        return redirect('/');
    }
}
