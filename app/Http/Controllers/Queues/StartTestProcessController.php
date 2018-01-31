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
        // passage d'arguments si besoin
    }

    /**
     * @param Request $request
     * @return string
     */
    function __invoke(Request $request)
    {
        $test = ["1", "2"];
        $urlGit = $request->urlGit;
        $mailUser = $request->mailUser;

        $message = '';

        $jobsList = new JobsList();
        $jobsList->save();

        $jobStatus = new JobStatus();

//        $wip = $jobStatus::find(1);
//        $jobEntity = new JobEntity();
//        $jobEntity->job_status_id = $wip->id;
//        $jobEntity->jobs_list_id = $jobsList->id;
//        $jobsList->entity()->save($jobEntity);
//
//        dispatch(new TestProcessEntity($urlGit,$jobEntity->id));

        $jobEntity = new JobEntity();
        $wip = $jobStatus::find(1);
        $jobEntity->job_status_id = $wip->id;
        $jobEntity->jobs_list_id = $jobsList->id;
//        $jobsList->entity()->save($jobEntity);
        $jobEntity->save();

        Log::info("mon id job entity", [
            'jobentity status' =>  15,
        ]);

//        $myjob = JobEntity::find($jobEntity->id);
//        $myjob->jobs_list_id = $myjob->jobsList()->first()->id;
//        $wip = $jobStatus::find(2);
//        $myjob->job_status_id =$wip->id;
//        $myjob->save();
//        dd($myjob->jobsList()->first()->id);


        dispatch(new TestFrontBackEntity($jobEntity));
//        try {
////            /** function gitClone */
//            $message .= 'git clone success';
//
//            /** on lance en queue cette fonction */

//
//
//        } catch (ModelNotFoundException $exception) {
//            /** catch en cas d'erreur importante */
//            abort(Response::HTTP_BAD_REQUEST, 'Url does not exist.');
//        }

        return " test done";
        /** Message envoyé directement sans attendre la fin des dispatch */
//        $message .= 'An email has been dispatched to userName about a test for this git Project ' . $urlGit;

    }
}
