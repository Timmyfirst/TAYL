<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\DB;

class GetIdController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $idJobList = $request->idJobList;


        $jobsList = new JobsList();
//        $jobsList = $jobsList::find($idJobList);

//        $jobStatus = new JobStatus();
        $jobEntities = DB::table('job_entity')->where('jobs_list_id', $idJobList)->get();

//        $wip = $jobStatus::find(1);
//        $jobEntity = new JobEntity();
//        $jobEntity->job_status_id = $wip->id;
//        $jobEntity->jobs_list_id = $jobsList->id;
//        $jobsList->entity()->save($jobEntity);

        return response()->json([
            'GetIdController' => 'id',
            'state' => $idJobList,
            'check' => 0,
            'phplocstatus' => 'En cours de traitement',
            'codesnifferstatus' =>'En cours de traitement',
            'joblist' => $jobEntities,
            'request' => $request
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
