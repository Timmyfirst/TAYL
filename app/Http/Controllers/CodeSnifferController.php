<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\LogTest;
use Illuminate\Support\Facades\DB;


class CodeSnifferController extends Controller
{
    public function CreateLog(){

        /*recupere la date pour le mettre à la fin du nom de fichier log*/
        $date =  date('YjdGis');
        $nameLogFile= 'logSniff'.$date.'.txt';
        $doc_name = public_path() . "/storage/";

        /*execute une commande permettant d'executer code sniffer et d'envoyer le resultat dans un fichier log*/
        shell_exec( 'cd '.$doc_name .' && phpcs project > logProject/'.$nameLogFile);

        /*Insert dans la table log*/
         DB::table('log')->insert(
            ['path' => '/logProject/'.$nameLogFile]
        );

    }
}
