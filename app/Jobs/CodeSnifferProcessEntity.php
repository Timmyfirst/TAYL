<?php

namespace App\Jobs;

use App\JobEntity;
use App\JobsList;
use App\JobStatus;
use App\Http\Controllers\CodeSnifferController;
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

        $CodeSniffer = new CodeSnifferController();
        $CodeSniffer->CreateCodeSnifferLog();

        $wip = JobStatus::find(2);

        Log::info("my job entity", [
            'jobentity id' => $this->jobEntity->id,
            'jobentity status' => $wip->id,
        ]);

        $JobEntity = JobEntity::find($this->jobEntity->id);
        $JobEntity->job_status_id = $wip->id;
        $JobEntity->save();

        Log::info("save job entity", [
            'jobentity id' => $JobEntity->id,
            'jobentity status' => $JobEntity->job_status_id,
        ]);

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
}
