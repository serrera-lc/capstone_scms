<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Student Feedback Form
    public function index()
    {
        return view('student_feedback');
    }

    // Store Student Feedback
    public function store(Request $request)
    {
        // validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_year' => 'required|string|max:255',
            'counselor' => 'required|string|max:255',
            'purpose' => 'array',
            'like' => 'nullable|string',
            'suggestions' => 'nullable|string',
        ]);

        // save to DB
        Feedback::create([
            'student_id' => auth()->id(),
            'name' => $validated['name'],
            'course_year' => $validated['course_year'],
            'counselor' => $validated['counselor'],
            'purpose' => $validated['purpose'] ?? [],
            'like' => $validated['like'] ?? null,
            'suggestions' => $validated['suggestions'] ?? null,
        ]);

        return redirect()->route('student.feedback')->with('success', 'Feedback submitted successfully!');
    }

    // ✅ New: Admin Feedback Listing
    public function adminIndex()
    {
        // Get all feedbacks (latest first)
        $feedbacks = Feedback::latest()->paginate(10); // with pagination

        // Pass to admin_feedback.blade.php
        return view('admin_feedback', compact('feedbacks'));
    }
}
