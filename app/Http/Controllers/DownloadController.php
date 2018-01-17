<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{

  public function store($link)
  {
      $link = 'https://github.com/exakat/php-static-analysis-tools.git';
      $link_decode = urldecode($link);
      $nom_proj = substr($link_decode, (strrpos($link_decode, '/', -1) + 1), (strlen($link_decode) - strrpos($link_decode, '/', -1) - 5));
      //https://github.com/exakat/php-static-analysis-tools.git

      $command = '';

      $commands_arr = array(
        1 => "cd /home/apprenant/Bureau/V/TAYL-back/public/",
        2 => "git clone " . $link,
        3 => "cd " . $nom_proj
      );

      $cmd_count = "cd /home/apprenant/Bureau/V/TAYL-back/public/" . $nom_proj . " && ls -1 | wc -l";
      /*
      for ($i = 1; $i <= count($commands_arr); $i++) {
          if ($i = 1) {
            $command = $commands_arr[$i] . ' && ';
          } elseif ($i = count($commands_arr)) {
            $command = $command . $commands_arr[$i];
          } else {
            $command = $command . $commands_arr[$i] . ' && ';
          }
      }*/

      $command = $commands_arr[1] . ' && ' . $commands_arr[2] . ' && ' . $commands_arr[3];

      //return
      shell_exec($command);

      //return count($commands_arr);
      return shell_exec($cmd_count);
  }

}
