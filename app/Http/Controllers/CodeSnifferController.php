<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\LogTest;
use Illuminate\Support\Facades\DB;


class CodeSnifferController extends Controller
{
    public function CreateCodeSnifferLog(){

        /*recupere la date pour le mettre à la fin du nom de fichier log*/
        $date =  date('Y_m_d_G-i-s');
        $nameLogFile= 'logSniff'.$date.'.txt';
        $pathStorage = public_path() . "/storage/";

        /*execute une commande permettant d'executer code sniffer et d'envoyer le resultat dans un fichier log*/
        shell_exec( 'cd '.$pathStorage .' && phpcs project > logProject/'.$nameLogFile);

        /*Insert dans la table log*/
        $logTest = new LogTest;
        $logTest->path = '/logProject/'.$nameLogFile;
        $logTest->type = 'CodeSniffer';
        $logTest->save();
    }


}
