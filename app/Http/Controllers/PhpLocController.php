<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\LogTest;
use Illuminate\Support\Facades\DB;


class PhpLocController extends Controller
{
    public function CreatePhpLocLog(){

        /*get the date to put it at the end of the log file name*/
        $date =  date('Y_m_d_G-i-s');
        $nameLogFile= 'logPhpLoc'.$date.'.txt';
        $pathStorage = public_path() . "/storage/";

        /*execute a command to execute "phploc" and send the result to a log file*/
        shell_exec( 'cd '.$pathStorage .' && phploc project > logProject/'.$nameLogFile);

        /*Insert in log table*/
        $logTest = new LogTest;
        $logTest->path = '/logProject/'.$nameLogFile;
        $logTest->type = 'PhpLoc';
        $logTest->save();
    }
}
