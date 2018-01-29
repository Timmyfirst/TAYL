<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\LogTest;
use Illuminate\Support\Facades\DB;


class CodeSnifferController extends Controller
{
    public function CreateCodeSnifferLog(){

        /*get the date to put it at the end of the log file name*/
        $date =  date('Y_m_d_G-i-s');
        $nameLogFile= 'logSniff'.$date;
        $pathStorage = public_path() . "/storage/";

        /*execute a command to execute "code sniffer" and send the result to a log file*/
        shell_exec( 'cd '.$pathStorage .' && phpcs project > logProject/'.$nameLogFile.'.txt');
        shell_exec( 'cd '.$pathStorage .' && phpcs project --report=json > logProject/'.$nameLogFile.'.json');


        /*Insert in log table */
        $logTest = new LogTest;
        $logTest->path = '/logProject/'.$nameLogFile;
        $logTest->type = 'CodeSniffer';
        $logTest->save();
    }


}
