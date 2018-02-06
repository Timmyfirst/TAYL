<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\LogTest;
use Illuminate\Support\Facades\DB;


class CodeSnifferController extends Controller
{

    public function createCodeSnifferLog($urlGit){

        $projectName =  $this->getProjectName($urlGit);
        /*get the date to put it at the end of the log file name*/
        $date =  date('Y_m_d_G-i-s');
        $nameLogFile= $projectName.'_logSniff'.$date;
        $pathStorage = public_path() . "/storage/";
        $pathFinalLog= $pathStorage.'/logProject/'.$projectName.'_FinalLog.json';

        /*execute a command to execute "code sniffer" and send the result to a log file*/
        shell_exec( 'cd '.$pathStorage .' && phpcs project > logProject/'.$nameLogFile.'.txt');
        shell_exec( 'cd '.$pathStorage .' && phpcs project --report=json > logProject/'.$nameLogFile.'.json');


        /*recup logSniff*/
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
            $JsonFileFinal= '{'.$recupJsonFileFinal.',"codeSniff":'.$json_source.'}';
        }else{
            $JsonFileFinal= '{"codeSniff":'.$json_source.'}';
        }
        /*write in FinalLogJson*/
        file_put_contents($pathFinalLog, $JsonFileFinal);

        $this->insertDB($nameLogFile);
    }
    public function insertDB($nameLogFile){
        /*Insert in log table */
        $logTest = new LogTest;
        $logTest->path = '/logProject/'.$nameLogFile;
        $logTest->type = 'CodeSniffer';
        $logTest->save();
    }

    /* Make project name */
    public function getProjectName($link) {
        return $proj_name = substr($link, (strrpos($link, '/', -1) + 1), (strlen($link) - strrpos($link, '/', -1) - 5));
    }

}
