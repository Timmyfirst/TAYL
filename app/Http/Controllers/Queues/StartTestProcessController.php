<?php

namespace App\Http\Controllers\Queues;

use App\Http\Controllers\Controller;
use App\JobEntity;
use App\Jobs\TestFrontBackEntity;
use App\Jobs\TestProcessEntity;
use App\JobsList;
use App\JobStatus;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class StartTestProcessController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return string
     */
    function __invoke(Request $request)
    {
        $jobsList = new JobsList();
        $jobsList->save();

        $jobEntity = new JobEntity();
        $wip = JobStatus::find(1);
        $jobEntity->job_status_id = $wip->id;
        $jobEntity->jobs_list_id = $jobsList->id;
        $jobEntity->save();

        Log::info("launch this job", [
            'jobentity id' =>  $jobEntity->id,
            'jobentity JobList id' =>  $jobsList->id,
        ]);

        dispatch(new TestFrontBackEntity($jobEntity));

        return "test in process";

    }
}
