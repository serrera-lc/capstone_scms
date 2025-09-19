<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Table name (optional if same as plural of model)
    protected $table = 'feedback';

    // Primary key (optional since Laravel defaults to "id")
    protected $primaryKey = 'id';

    // Fillable fields for mass assignment
    protected $fillable = [
        'student_id',
        'name',
        'course_year',
        'counselor',
        'purpose',
        'like',
        'suggestions',
    ];

    // Cast "purpose" column to array (since it’s JSON)
    protected $casts = [
        'purpose' => 'array',
    ];

    /**
     * Relationship with Student (if you have a Student model)
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
