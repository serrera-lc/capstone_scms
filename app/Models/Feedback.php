<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'counselor_id',  // ✅ added for selected counselor
        'session_id',    // optional link to session
        'feedback',      // feedback text
        'rating',        // numeric rating
    ];

    // Student who submitted the feedback
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Counselor the feedback is about
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    // Optional: Counseling session related to the feedback
    public function counselingSession()
    {
        return $this->belongsTo(CounselingSession::class, 'session_id');
    }
}
