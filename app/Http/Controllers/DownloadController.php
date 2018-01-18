<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{

  public function store($link)
  {
      //$link_decode = urldecode($link);

      /* Constitution du nom du projet */
      $nom_proj = substr($link_decode, (strrpos($link_decode, '/', -1) + 1), (strlen($link_decode) - strrpos($link_decode, '/', -1) - 5));

      /* Initialisation de la commande de clone */
      $command = '';

      /* Récupération de l'emplacement du dossier "public" */
      $dir = shell_exec('pwd');

      /* Liste des commandes à faire */
      $commands_arr = array(
        1 => "git clone " . $link,
        2 => "cd " . $nom_proj
      );

      /* Composition de la commande pour compter les fichiers */
      $cmd_count = "cd " . substr($dir, 0, strlen($dir)-1) . "/" . $nom_proj . " && ls -1 | wc -l";

      /* Composition de la commande de clone */
      for ($i = 1; $i <= count($commands_arr); $i++) {
          if ($i == count($commands_arr)) {
            $command = $command . $commands_arr[$i];
          } else {
            $command = $command . $commands_arr[$i] . ' && ';
          }
      }

      /* Exécution */
      shell_exec($command);
      
      /* Exécution  et retour */
      return shell_exec($cmd_count);
  }

}
