<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ctgList',
        'desc',
        'est',
        'img',
        'title',
        'totalEst',
        'vid',
        'workoutEsts',
        'workoutLists',
        'workoutId',
    ];

    public function WorkoutPrograms() { 
        return $this->belongsToMany(WorkoutProgram::class, 'workoutId', 'workouts');
    }
}
