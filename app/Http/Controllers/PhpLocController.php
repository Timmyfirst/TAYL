<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\LogTest;
use Illuminate\Support\Facades\DB;


class PhpLocController extends Controller
{
    public function createPhpLocLog($urlGit,$jobsListId){

        $projectName =  $this->getProjectName($urlGit);
        /*get the date to put it at the end of the log file name*/
        $date =  date('Y_m_d_G-i-s');
        $nameLogFile= $projectName.'_logPhpLoc'.$jobsListId;
        $pathStorage = public_path() . "/storage/";
        $pathFinalLog= $pathStorage.'/logProject/'.$projectName.'_FinalLog'.$jobsListId.'.json';

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
        $finalLogJsonExist=  file_exists($pathFinalLog);
        if($finalLogJsonExist){
            /*recup FinalLogJson*/
            $recupJsonFileFinal = file_get_contents($pathFinalLog);
        }else{
            /*create FinalLogJson*/
            file_put_contents($pathFinalLog, '');
            $recupJsonFileFinal = '';
        }
        /*delete first and last caratere*/
        $recupJsonFileFinal = substr($recupJsonFileFinal,1,-1);
        /*check if FinalLogJson is empty and concat FinalLogJson and logPhpLoc  */
        if(!empty($recupJsonFileFinal)){
                $jsonFileFinal= '{'.$recupJsonFileFinal.','.$json_source.'}';
            }else{
                $jsonFileFinal= '{'.$json_source.'}';
            }
        /*write in FinalLogJson*/
        file_put_contents($pathFinalLog, $jsonFileFinal);



        $this->insertDB($nameLogFile);
    }
    public function insertDB($nameLogFile){
        /*Insert in log table */
        $logTest = new LogTest;
        $logTest->path = '/logProject/'.$nameLogFile;
        $logTest->type = 'PhpLoc';
        $logTest->save();
    }
    /* Make project name */
    public function getProjectName($link) {
        return $proj_name = substr($link, (strrpos($link, '/', -1) + 1), (strlen($link) - strrpos($link, '/', -1) - 5));
    }
}
