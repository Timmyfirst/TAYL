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
        $wip = JobStatus::find(2);

        Log::info("my job entity", [
            'jobentity id' => $this->jobEntity->id,
            'jobentity status' => $wip->id,
        ]);


        saveJobEntitySuccess($this->jobEntity->id);

        Log::info("save job entity", [
            'jobentity id' => $this->jobEntity->id,
        ]);
    }

    /**
     **
     */
    public function failed()
    {
        saveJobEntityFailed($this->jobEntity->id);
        Log::info("mon id job entity failed", [
            'jobentity id' => $this->jobEntity->id,
        ]);
    }

}
