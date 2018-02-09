<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{

    protected $table = 'job_status';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name'
    ];
}
