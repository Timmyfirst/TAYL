<?php

namespace App\Jobs;

use App\JobEntity;
use App\JobStatus;
use App\Mail\resultMail;
use App\Notifications\TestedProcessEntity;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Zttp\Zttp;
use Zttp\ZttpResponse;
use Exception;

class TestProcessEntity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Url Git to fetch
     *
     * @var string
     */
    private $urlGit;

    private $response;

    private $id_jobEntity;


    /**
     * Create a new job instance.
     *
     *  commande pour créer un job : php artisan make:job nomDuJobEntity
     *
     * @param string $urlGit
     */
    public function __construct(string $urlGit,int $id_jobEntity)
    {
        /** ajouter un paramètre */
        $this->setUrlGit($urlGit);
        $this->setIdJobEntity($id_jobEntity);
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        /** on a eu pour ordre de lancer cette fonction */
        /** stop 10sec */
        usleep(100000);

        // And sometimes i'll just randomly fail.
//        if(rand(1, 100) >= 50) throw new \Exception('Everything is horrible.');


        $jobStatus = new JobStatus();
        $jobEntity = new JobEntity();
        $jobEntity::find($this->getIdJobEntity());
        $jobEntity->jobs_list_id = $jobEntity->jobsList()->first()->id;
        $jobEntity->job_status_id = $jobStatus::find(2);
        $jobEntity->save();
    }

    public function failed(Exception $exception)
    {
        Log::error("failed job error name : ", [
            'error' => "mon erreur",
        ]);

        $jobStatus = new JobStatus();
        $jobEntity = new JobEntity();
        $jobEntity::find($this->getIdJobEntity());
        $jobEntity->jobs_list_id = $jobEntity->jobsList()->first()->id;
        $jobEntity->job_status_id = $jobStatus::find(3);;
        $jobEntity->save();

        return 'failed';
    }

    public function getResponse()
    {
        return $this->response;
    }


    /**
     * set l'url en paramètre
     * @param string $urlGitgetUrlGit
     */
    public function setResponse(string $response)
    {
        $this->response = $response;
    }

    /**
     * getter de l'url en paramètre
     * @return string
     */
    public function getUrlGit(): string
    {
        return $this->urlGit;
    }

    /**
     * set l'url en paramètre
     * @param string $urlGitgetUrlGit
     */
    public function setUrlGit(string $urlGit)
    {
        $this->urlGit = $urlGit;
    }

    /**
     * getter de l'url en paramètre
     * @return string
     */
    public function getIdJobEntity(): string
    {
        return $this->id_jobEntity;
    }

    /**
     * set l'url en paramètre
     * @param string $urlGitgetUrlGit
     */
    public function setIdJobEntity(string $id_jobEntity)
    {
        $this->id_jobEntity = $id_jobEntity;
    }
}
