<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sqits\UserStamps\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, HasUserStamps, SoftDeletes;

    protected $table = 'candidates';
    protected $fillable = ['name', 'email', 'phone', 'year'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    // Tabel pivot relasi many to many
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_sets');
    }
}
