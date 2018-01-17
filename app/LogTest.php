<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class LogTest extends Model
{
    protected $table ='log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path'
    ];

}
