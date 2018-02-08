<?php

namespace App\Jobs;

use App\JobEntity;
use App\JobsList;
use App\JobStatus;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\CodeSnifferController;
use App\LogTest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;


class CodeSnifferProcessEntity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobEntity;
    protected $urlGit;
    protected $addressMail;
    protected $projectName;

    /**
     * Create a new job instance.
     *
     * @param JobEntity $jobEntity
     */
    public function __construct(JobEntity $jobEntity,$urlGit,$address)
    {
        $gitManager=new ProjectManagerController();
        /** ajouter un paramètre */
        $this->jobEntity = $jobEntity;
        $this->urlGit = $urlGit;
        $this->addressMail = $address;
        $this->projectName = $gitManager->getProjectName($urlGit);

    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** on a eu pour ordre de lancer cette fonction */
        /** stop 10sec */



        $wip = JobStatus::find(2);

        Log::info("my job entity", [
            'jobentity id' => $this->jobEntity->id,
            'jobentity status' => $wip->id,
            'url git' => $this->urlGit,
        ]);

        $this->createCodeSnifferLog($this->urlGit);

        $JobEntity = JobEntity::find($this->jobEntity->id);
        $JobEntity->job_status_id = $wip->id;
        $JobEntity->save();

        Log::info("save job entity", [
            'jobentity id' => $this->jobEntity->id,
            'jobentity status' => $JobEntity->job_status_id,
        ]);
        $fileLog= $this->projectName.'_logSniff'.$this->jobEntity->jobs_list_id;

        $mail = new SendMailController();
        $mail->SendMail($this->addressMail,'Code Sniffer',$this->projectName,$fileLog);

    }

    public function failed()
    {
        $wip = JobStatus::find(3);
        $JobEntity = JobEntity::find($this->jobEntity->id);
        $JobEntity->job_status_id = $wip->id;
        $JobEntity->save();
        Log::info("mon id job entity failed", [
            'jobentity id' => $this->jobEntity->id,
            'jobentity status' => $wip->id,
        ]);
    }

    public function createCodeSnifferLog($urlGit){

        $projectName =  $this->getProjectName($urlGit);
//        $projectName =  "TAYL-back";

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
