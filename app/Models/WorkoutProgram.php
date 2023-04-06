<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class WorkoutProgram extends Model
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
        'img',
        'title',
        'workouts',
    ];

    public function Workout() { 
        return $this->hasMany(Workout::class, 'workoutId', 'workouts');
    }
}
