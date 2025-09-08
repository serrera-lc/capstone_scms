<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'student_id');
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class, 'student_id');
    }

    public function offenses()
    {
        return $this->hasMany(Offense::class, 'student_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'student_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
