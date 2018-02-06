<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationEtherController extends Controller
{


    private $addressEther = '0x349dCe198199916DeAc175E0EbE0dFAF97642B8d';
    private $urlQrCode = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=0x349dCe198199916DeAc175E0EbE0dFAF97642B8d&choe=UTF-8';


    public function donationEtherRender(){

        return response()->json([
            'addressBitCoin' => $this->addressEther,
            'urlQrCode' => $this->urlQrCode
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
