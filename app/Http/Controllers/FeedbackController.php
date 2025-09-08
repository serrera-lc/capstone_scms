<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\User; // counselors & students
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // ===================== STUDENT VIEW =====================
    public function index()
    {
        // Get all counselors (role = 'counselor')
        $counselors = User::where('role', 'counselor')->get();

        // Get feedbacks for logged-in student
        $feedbacks = Feedback::where('student_id', Auth::id())
            ->latest()
            ->get();

        return view('student_feedback', compact('feedbacks', 'counselors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'feedback'     => 'required|string|max:500',
            'counselor_id' => 'required|exists:users,id', // select a counselor
            'rating'       => 'required|integer|min:1|max:5', // must rate 1-5
        ]);

        Feedback::create([
            'student_id'   => Auth::id(),
            'counselor_id' => $request->counselor_id,
            'feedback'     => $request->feedback,
            'rating'       => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Thank you! Your feedback has been submitted.');
    }

    // ===================== ADMIN VIEW =====================
    public function adminIndex()
    {
        // Admin sees all feedbacks with student & counselor info
        $feedbacks = Feedback::with(['student', 'counselor'])
            ->latest()
            ->get();

        return view('admin_feedbacks', compact('feedbacks'));
    }
}
