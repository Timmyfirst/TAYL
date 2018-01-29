<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\LogTest;
use Illuminate\Support\Facades\DB;


class CodeSnifferController extends Controller
{
    public function CreateLog($proj_name){

        /*recupere la date pour le mettre à la fin du nom de fichier log*/
        $date = date('YmdGis');
        $nameLogFile = 'logSniff'.$date.'.txt';
        $pathStorage = public_path() . "/storage/app/public";

        /*execute une commande permettant d'executer code sniffer et d'envoyer le resultat dans un fichier log*/
        echo shell_exec( 'cd '.$pathStorage .' && phpcs ' . $proj_name . ' > logProject/'.$nameLogFile);

        /*Insert dans la table log*/
        $logTest = new LogTest;
        $logTest->path = '/logProject/'.$nameLogFile;
        $logTest->save();
    }


}
