<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function kyc(){
        return view('dashboard/kyc');
    }

    public function settings(){
        return view('dashboard/settings');
    }
}
