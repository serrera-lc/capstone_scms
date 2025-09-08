<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offense extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'offense',
        'remarks',
        'date',
        'status',   // 👈 add this so status can be mass-assigned
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
