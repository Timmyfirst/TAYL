<?php

namespace App\Http\Controllers\Queues;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectManagerController;
use App\JobEntity;
use App\Jobs\ProjectDownload;
use App\Jobs\TestFrontBackEntity;
use App\Jobs\CodeSnifferProcessEntity;
use App\Jobs\PhpLocProcessEntity;
use App\Jobs\ParallelLintProcessEntity;
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


        $jobsList = new JobsList();
        $jobsList->save();

        $jobEntity = createJobEntity($jobsList->id);
        Log::info("launch this job", [
            'jobentity id' => $jobEntity->id,
            'jobentity JobList id' => $jobsList->id,
            'gitUrl' => $urlGit,
        ]);
//        $GitManager = new ProjectManagerController();
//        $GitManager->store($urlGit,$jobEntity);
        ProjectDownload::withChain([
                new CodeSnifferProcessEntity($jobEntity, $urlGit,$request->mailUser)
        ])->dispatch($urlGit, $jobEntity,$urlGit);

//        dispatch(new ProjectDownload($urlGit, $jobEntity,$urlGit));


//        if($request->codesniffer == 1) {
//            dispatch(new CodeSnifferProcessEntity($jobEntity, $urlGit));
//        }
//        else {
//            dispatch(new CodeSnifferProcessEntity($jobEntity, $urlGit));
//        }
//        if($request->phploc == 1) {
//            dispatch(new PhpLocProcessEntity($jobEntity, $urlGit));
//        } else {
//            dispatch(new PhpLocProcessEntity($jobEntity, $urlGit));
//        }
//        if($request->parallellint == 1) {
//            dispatch(new ParalleleLintProcessEntity($jobEntity, $urlGit));
//        } else {
//            dispatch(new ParalleleLintProcessEntity($jobEntity, $urlGit));
//        }
//        dispatch(new TestFrontBackEntity($jobEntity));


        //$GitManager->destroy($GitManager->getProjectName($urlGit));

        return response()->json([
            'idJobList' => $jobsList->id,
        ]);

    }
}
