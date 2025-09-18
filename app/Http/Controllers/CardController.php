<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(){
        return view('dashboard/cards');
    }

    public function create(){
        return view('dashboard/create_card');
    }
}
