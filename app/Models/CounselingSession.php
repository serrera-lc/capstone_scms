<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CounselingSession extends Model
{
    use HasFactory;

    protected $table = 'counseling_sessions'; // match migration name

    protected $fillable = ['student_id','counselor_id','concern','notes','date'];

    public function student() {
    return $this->belongsTo(User::class, 'student_id');
}

public function counselor() {
    return $this->belongsTo(User::class, 'counselor_id');
}


    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'session_id');
    }
}
