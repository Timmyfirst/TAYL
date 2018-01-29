<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class donationPayPalController extends Controller
{

    public function donationPayPalRender(){
        return view('donation/donationPayPal');
    }

}
