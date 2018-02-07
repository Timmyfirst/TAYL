<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsList extends Model
{

    protected $table = 'jobs_list';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','job_count'
    ];



    public function entity()
    {
        return $this->hasMany('App\JobEntity');
    }
}
