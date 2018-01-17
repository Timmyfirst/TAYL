<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;



class LogTest extends Model
{
    use Notifiable;
    protected $table ='logTests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path'
    ];

}
