<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class donationPayPalController extends Controller
{

    public function view(){
        return view('donation/donationPayPal');
    }
}
