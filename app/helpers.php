<?php

use App\JobEntity;
use App\JobStatus;

function saveJobEntitySuccess($id_jobEntity) {
    /** @var 2 is status complete $wip */
    $wip = JobStatus::find(2);
    $JobEntity = JobEntity::find($id_jobEntity);
    $JobEntity->job_status_id = $wip->id;
    $JobEntity->save();

}

function saveJobEntityFailed($id_jobEntity) {
    /** @var 3 is status failed $wip */
    $wip = JobStatus::find(3);
    $JobEntity = JobEntity::find($id_jobEntity);
    $JobEntity->job_status_id = $wip->id;
    $JobEntity->save();
}