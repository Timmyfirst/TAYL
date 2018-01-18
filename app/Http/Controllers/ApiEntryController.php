<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiEntryController extends Controller
{

  public function store($link)
  {
    if ($link === 'test_ok') {
      usleep(500000);
      return 'test ok';
    } else {
      return 'test échoué';
    }

  }

}
