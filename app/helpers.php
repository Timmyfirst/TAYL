<?php

use App\JobEntity;
use App\JobStatus;

/**
 * @param $id_jobEntity
 */
function saveJobEntitySuccess($id_jobEntity) {
    /** @var 2 is status complete $wip */
    $wip = JobStatus::find(2);
    $JobEntity = JobEntity::find($id_jobEntity);
    $JobEntity->job_status_id = $wip->id;
    $JobEntity->save();

}

/**
 * @param $id_jobEntity
 */
function saveJobEntityFailed($id_jobEntity) {
    /** @var 3 is status failed $wip */
    $wip = JobStatus::find(3);
    $JobEntity = JobEntity::find($id_jobEntity);
    $JobEntity->job_status_id = $wip->id;
    $JobEntity->save();
}

/**
 * @param $id_jobsList
 * @return JobEntity
 */
function createJobEntity($id_jobsList){
    $jobEntity = new JobEntity();
    /** @var 1 is status in progress $wip */
    $wip = JobStatus::find(1);
    $jobEntity->job_status_id = $wip->id;
    $jobEntity->jobs_list_id = $id_jobsList;
    $jobEntity->save();

    return $jobEntity;
}