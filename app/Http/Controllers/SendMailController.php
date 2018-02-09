<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestFinishedSendMail;
use Mail;

class SendMailController extends Controller
{

  public $Test;
  public $Projet;
  public $Address;
  public $FileName;

  /**
   * Show the application sendMail.
   *
   * @return \Illuminate\Http\Response
   */

  public function SendMail($address, $test, $projet, $filename) {
    $this->Test = $test;
    $this->Projet = $projet;
    $this->Address = $address;
    $this->FileName = $filename;

    $receiverAddress = $this->Address;

    Mail::to($receiverAddress)->send(new TestFinishedSendMail($this->Test, $this->Projet, $this->FileName));
  }


}
