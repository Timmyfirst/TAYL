<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UrlSenderController extends Controller
{

  public function create()
  {
      return view('input');
  }

  public function store()
  {

  }

}
