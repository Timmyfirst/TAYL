<?php

namespace App\Jobs;

use App\JobEntity;
use App\JobsList;
use App\JobStatus;
use http\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class TestFrontBackEntity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobEntity;

    /**
     * Create a new job instance.
     *
     * @param JobEntity $jobEntity
     */
    public function __construct(JobEntity $jobEntity)
    {
        /** ajouter un paramètre */
        $this->jobEntity = $jobEntity;
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
        // And sometimes i'll just randomly fail.
//        $jobEntity = new JobEntity();
//        $jobStatus = new JobStatus();
//        $wip = $jobStatus::find(3);

        Log::info("mon id job entity", [
            'jobentity id' => $this->jobEntity->id,
            'jobentity status' =>  "dans handle",
        ]);
        $JobEntity = JobEntity::find($this->jobEntity->id);
        $JobEntity->job_status_id = 3;
        $JobEntity->save();

        Log::info("save", [
            'jobentity id' => $JobEntity->id,
            'jobentity status' =>  $JobEntity->job_status_id,
        ]);
    }

    public function failed(Exception $exception)
    {
//        $jobStatus = new JobStatus();
//        $jobEntity = new JobEntity();
//        $jobEntity::find($this->getIdJobEntity());
//        $jobEntity->jobs_list_id = $jobEntity->jobsList()->first()->id;
//        $jobEntity->job_status_id = $jobStatus::find(3);;
//        $jobEntity->save();

        return 'failed';
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
