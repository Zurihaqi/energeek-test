<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sqits\UserStamps\Concerns\HasUserStamps;

class Skill extends Model
{
    use HasFactory, HasUserStamps;

    protected $table = 'skills';
    protected $fillable = ['name'];

    // Tabel pivot relasi many to many
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'skill_sets');
    }
}
