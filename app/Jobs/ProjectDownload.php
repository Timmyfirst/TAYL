<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProjectDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    private $link;
    /**
     * @var
     */
    private $jobEntity;
    /**
     * @var
     */
    private $urlGit;

    /**
     * Create a new job instance.
     *
     * @param $link
     * @param $jobEntity
     * @param $urlGit
     */
    public function __construct($link,$jobEntity,$urlGit)
    {
        //
        $this->link = $link;
        $this->jobEntity = $jobEntity;
        $this->urlGit = $urlGit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* Get project name */
        $proj_name = $this->getProjectName($this->link);

        /* Initialisation of clone command */
        $command = '';

        /* get path of "public" directory */
//        $dir = public_path() . "/storage/project";

        /* Get count command */
//        $cmd_count = $this->getCmdCount($dir, $proj_name);

        /* Get download command */
        $command = $this->getCmdDownload($this->link, $proj_name);

        /* Execution of command */
        shell_exec($command . '2>&1');
    }

    /* Make project name */
    public function getProjectName($link) {
        return $proj_name = substr($link, (strrpos($link, '/', -1) + 1), (strlen($link) - strrpos($link, '/', -1) - 5));
    }

    /* Make download command */
    private function getCmdDownload($link, $proj_name) {
        $command = '';

        $commands_arr = array(
            1 => "cd ".public_path()."/storage/project && git clone --depth 1 " . $link,
            2 => "cd " . $proj_name
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
        return $cmd_count = "cd " . substr($dir, 0, strlen($dir)-1) . "/" . $proj_name . " && ls -1 | wc -l";
    }

    public function destroy($link)
    {
        /* Get project name */
        $proj_name = $this->getProjectName($link);

        /* Initialisation delete command */
        $command = 'cd ' . public_path() . '/storage/project && rm -rf '. $proj_name;

        return shell_exec($command . ' 2>&1');

    }
}
