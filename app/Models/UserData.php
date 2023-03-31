<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userEmail', 
        'activity',
        'age',
        'calPerDayHold',
        'calPerDayLose',
        'dateOfBirth',
        'gender',
        'height',
        'imt',
        'imtStatus',
        'isFilled',
        'medicalCondition',
        'recommendation',
        'weight',
        'profileUrl',
    ];

    public function user() { 
        return $this->belongsTo(User::class, 'userEmail', 'email');
    }
}
