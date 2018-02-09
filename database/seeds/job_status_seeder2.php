<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class job_status_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_status')->delete();

        $now = date('Y-m-d H:i:s');

        DB::table('job_status')->insert([
            'name' => 'In progress',
            'created_at'=>	$now,
            'updated_at'=>	$now,

        ]);
        DB::table('job_status')->insert([
            'name' => 'Complete',
            'created_at'=>	$now,
            'updated_at'=>	$now,

        ]);
        DB::table('job_status')->insert([
            'name' => 'Failed',
            'created_at'=>	$now,
            'updated_at'=>	$now,

        ]);
    }
}
