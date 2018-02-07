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
        $countTest= 0;

        if($request->codesniffer == 1) {
            $countTest++;
        }
        if($request->phploc == 1) {
            $countTest++;
        }
        if($request->parallelelint == 1) {
            $countTest++;
        }

        $jobsList = new JobsList();
        $jobsList->job_count=$countTest;
        $jobsList->save();
        $jobEntity = createJobEntity($jobsList->id);
        Log::info("launch this job", [
            'jobentity id' =>  $jobEntity->id,
            'jobentity JobList id' =>  $jobsList->id,
        ]);


        if($request->codesniffer == 1) {
            sleep(2);
            dispatch(new CodeSnifferProcessEntity($jobEntity, $urlGit));

        } else {
            dispatch(new CodeSnifferProcessEntity($jobEntity, $urlGit));
        }
        if($request->phploc == 1) {
            sleep(2);
            dispatch(new PhpLocProcessEntity($jobEntity, $urlGit));

        } else {
            dispatch(new PhpLocProcessEntity($jobEntity, $urlGit));
        }
        if($request->parallellint == 1) {
            sleep(2);
            dispatch(new ParallelLintProcessEntity($jobEntity, $urlGit));

        } else {
            dispatch(new ParallelLintProcessEntity($jobEntity, $urlGit));
        }


        do{
            $jobList = new JobsList();
            $jobList = $jobList::find($jobsList->id);
            //dd($jobList->job_count);
            echo $jobList->job_count;
            if($jobList->job_count == 0){
                echo 'destroy';
                $GitManager->destroy($urlGit);
            }
        }while($jobList->job_count >0);


//        dispatch(new TestFrontBackEntity($jobEntity));


        //$GitManager->destroy($GitManager->getProjectName($urlGit));
        return response()->json([
            'idJobList' => $jobsList->id
        ]);

    }
}
