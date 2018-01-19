<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{

  public function store($link)
  {

      /* Get project name */
      $proj_name = $this->getProjectName($link);

      /* Initialisation of clone command */
      $command = '';

      /* get path of "public" directory */
      $dir = shell_exec('pwd');

      /* Get count command */
      $cmd_count = $this->getCmdCount($dir, $proj_name);

      /* Get download command */
      $command = $this->getCmdDownload($link, $proj_name);

      /* Execution of command */
      shell_exec($command);

      /* Execution and return */
      return shell_exec($cmd_count);
  }

  /* Make project name */
  public function getProjectName($link) {
    return $proj_name = substr($link, (strrpos($link, '/', -1) + 1), (strlen($link) - strrpos($link, '/', -1) - 5));
  }

  /* Make download command */
  private function getCmdDownload($link, $proj_name) {
    $command = '';

    $commands_arr = array(
      1 => "cd storage",
      2 => "git clone " . $link,
      3 => "cd " . $proj_name
    );

    for ($i = 1; $i <= count($commands_arr); $i++) {
        if ($i == count($commands_arr)) {
          $command = $command . $commands_arr[$i];
        } else {
          $command = $command . $commands_arr[$i] . ' && ';
        }
    }

    return $command;
  }

  /* Make count command */
  private function getCmdCount($dir, $proj_name) {
    return $cmd_count = "cd " . substr($dir, 0, strlen($dir)-1) . "/storage/" . $proj_name . " && ls -1 | wc -l";
  }

}
