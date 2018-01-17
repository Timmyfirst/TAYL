<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class LogTest extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path213'
    ];

}
