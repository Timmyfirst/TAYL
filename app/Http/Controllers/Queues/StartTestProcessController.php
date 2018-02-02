<?php

namespace App\Http\Controllers\Queues;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectManagerController;
use App\JobEntity;
use App\Jobs\TestFrontBackEntity;
use App\Jobs\CodeSnifferProcessEntity;
use App\Jobs\PhpLocProcessEntity;
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
        $urlGit = $request->urlGit;
        $GitManager = new ProjectManagerController();
        $GitManager->store($urlGit);

        $jobsList = new JobsList();
        $jobsList->save();

        $jobEntity = createJobEntity($jobsList->id);


        Log::info("launch this job", [
            'jobentity id' =>  $jobEntity->id,
            'jobentity JobList id' =>  $jobsList->id,
        ]);

        dispatch(new CodeSnifferProcessEntity($jobEntity));
        dispatch(new PhpLocProcessEntity($jobEntity));
        dispatch(new TestFrontBackEntity($jobEntity));

        $GitManager->destroy($GitManager->getProjectName($urlGit));

        return response()->json([
            'GetIdController' => 'id',
            'state' => 1,
            'check' => 0,
            'phplocstatus' => 'En cours de traitement',
            'codesnifferstatus' =>'En cours de traitement',
            'joblist' => 1,
            'request' => 1,
            'idJobList' => $jobsList->id
        ]);

    }
}
