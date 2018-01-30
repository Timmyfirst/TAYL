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
        $nameLogFile= 'logPhpLoc'.$date;
        $pathStorage = public_path() . "/storage/";

        /*execute a command to execute "phploc" and send the result to a log file*/
        shell_exec( 'cd '.$pathStorage .' && phploc project > logProject/'.$nameLogFile.'.txt');
        shell_exec( 'cd '.$pathStorage .' && phploc project --log-xml logProject/'.$nameLogFile.'.xml');


        /*create file Xml*/
        $logXml = simplexml_load_file($pathStorage.'logProject/'.$nameLogFile.'.xml');

        /*convert file xml in json*/
        $jsonTab = json_encode($logXml);

        /*write in file json*/
        $fp=fopen($pathStorage.'/logProject/'.$nameLogFile.'.json','w');
        if ($fp==false)
        {echo 'echec';
        }
        else {
            fputs($fp, '[' . $jsonTab . ']');
            fclose($fp);
        }


        /*Insert in log table*/
        $logTest = new LogTest;
        $logTest->path = '/logProject/'.$nameLogFile;
        $logTest->type = 'PhpLoc';
        $logTest->save();
    }
}
