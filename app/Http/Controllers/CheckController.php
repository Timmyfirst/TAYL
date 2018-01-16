<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckController extends Controller
{

  public function start($link)
  {
    if ($link == 'test_ok') {
      usleep(500000);
      return 'test ok';
    } else {
      return 'test échoué';
    }

  }

}
