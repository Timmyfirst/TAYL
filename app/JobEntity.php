<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobEntity extends Model
{

    protected $table = 'job_entity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','jobs_list_id','job_status_id',
    ];

    /**
     * Get the post that owns the comment.
     */
    public function jobsList()
    {
        return $this->belongsTo('App\JobsList');
    }
}
