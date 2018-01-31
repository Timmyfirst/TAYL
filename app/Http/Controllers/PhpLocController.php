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
        file_put_contents($pathStorage.'/logProject/'.$nameLogFile.'.json', '"phpLoc":' . $jsonTab . '');


        /*recup logPhpLoc*/
        $json_source = file_get_contents($pathStorage.'/logProject/'.$nameLogFile.'.json');

        /*check if FinalLogJson exists */
        $FinalLogJsonExist=  file_exists($pathStorage.'/logProject/FinalLogJson.json');
        if($FinalLogJsonExist){
            /*recup FinalLogJson*/
            $RecupJsonFileFinal = file_get_contents($pathStorage.'/logProject/FinalLogJson.json');
        }else{
            /*create FinalLogJson*/
            file_put_contents($pathStorage.'/logProject/FinalLogJson.json', '');
            $RecupJsonFileFinal = '';
        }
        /*delete first and last caratere*/
        $RecupJsonFileFinal = substr($RecupJsonFileFinal,1,-1);
        /*check if FinalLogJson is empty and concat FinalLogJson and logPhpLoc  */
        if(!empty($RecupJsonFileFinal)){
                $JsonFileFinal= '{'.$RecupJsonFileFinal.','.$json_source.'}';
            }else{
                 $JsonFileFinal= '{'.$json_source.'}';
            }
        /*write in FinalLogJson*/
        file_put_contents($pathStorage.'/logProject/FinalLogJson.json', $JsonFileFinal);



        /*Insert in log table*/
        $logTest = new LogTest;
        $logTest->path = '/logProject/'.$nameLogFile;
        $logTest->type = 'PhpLoc';
        $logTest->save();
    }
}
