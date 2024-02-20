<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create(['name' => 'PHP']);
        Skill::create(['name' => 'PostgreSQL']);
        Skill::create(['name' => 'API (JSON, REST)']);
        Skill::create(['name' => 'Version Control System (Gitlab, Github)']);
    }
}
