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
    private $urlQrCode = 'https://blockchain.info/fr/qr?data=1J9NHCGjuZnQcyHN35zZEagJ8Q2Nzjoyno&size=200';


    public function donationPayPalRender(){

        return  View::make('donation/donationBitCoin', array('addressBitCoin' => $this->addressBitCoin, 'urlQrCode' => $this->urlQrCode));
    }


}
