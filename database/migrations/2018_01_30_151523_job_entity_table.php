<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_entity', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('jobs_list_id')->unsigned();
            $table->foreign('jobs_list_id')->references('id')->on('jobs_list');

            $table->integer('job_status_id')->unsigned();
            $table->foreign('job_status_id')->references('id')->on('job_status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_entity');
    }
}
