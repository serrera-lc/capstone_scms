<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Add `status` so it can be mass assigned
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'grade_level',
        'strand',
        'status', // <-- NEW
    ];

    // Relationships
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

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    // ✅ Helper method to check if user is active
    public function isActive()
    {
        return $this->status === 'active';
    }
}
