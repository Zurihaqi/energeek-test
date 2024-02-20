<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::create(['name' => 'Frontend Web Programmer']);
        Job::create(['name' => 'Fullstack Web Programmer']);
        Job::create(['name' => 'Quality Control']);
    }
}
