<?php

use App\JobEntity;
use App\JobsList;
use App\JobStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('job_entity_seeder');
        $this->call('jobs_list_seeder');
        $this->call('job_status_seeder');

        $this->command->info("Tables successfully seeded :)");
    }
}
