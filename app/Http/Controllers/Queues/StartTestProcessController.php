<?php
namespace App\Http\Controllers\Queues;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectManagerController;
use App\JobEntity;
use App\Jobs\TestFrontBackEntity;
use App\Jobs\CodeSnifferProcessEntity;
use App\Jobs\PhpLocProcessEntity;
use App\Jobs\ParalleleLintProcessEntity;
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
        dispatch(new CodeSnifferProcessEntity($jobEntity,$urlGit));
        dispatch(new PhpLocProcessEntity($jobEntity,$urlGit));
        dispatch(new ParalleleLintProcessEntity($jobEntity,$urlGit));
//        dispatch(new TestFrontBackEntity($jobEntity));

        return "test in process";
    }
}