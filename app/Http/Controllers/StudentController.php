<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function profile()
    {
        $student = auth()->user();
        return view('student_profile', compact('student'));
    }
}
