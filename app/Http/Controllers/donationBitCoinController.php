<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

class donationBitCoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $addressBitCoin = '1J9NHCGjuZnQcyHN35zZEagJ8Q2Nzjoyno';
    private $urlQrCode = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=1J9NHCGjuZnQcyHN35zZEagJ8Q2Nzjoyno&choe=UTF-8';


    public function donationPayPalRender(){

        return response()->json([
            'addressBitCoin' => $this->addressBitCoin,
            'urlQrCode' => $this->urlQrCode
        ]);
    }


}
