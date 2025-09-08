<?php

namespace App\Http\Controllers;

use App\Models\CounselingSession;
use App\Models\User;
use Illuminate\Http\Request;

class CounselingSessionController extends Controller
{
 public function index()
{
    $counselorId = 1; // Replace with auth()->id() if using login

    $sessions = CounselingSession::with('student')
        ->where('counselor_id', $counselorId)
        ->latest()
        ->get();

    // Make sure students are passed for the dropdown
    $students = User::where('role', 'student')->get();

    return view('counselor_sessions', compact('sessions', 'students'));
}

    public function create()
    {
        return view('counselor_session_form');
    }

 public function store(Request $request)
{
    $counselorId = 1; // Replace with auth()->id() if using login

    $request->validate([
        'student_id' => 'required|exists:users,id',
        'concern'    => 'required|string|max:255',
        'notes'      => 'nullable|string',
        'date'       => 'required|date',
    ]);

    CounselingSession::create([
        'student_id'   => $request->student_id,
        'counselor_id' => $counselorId,
        'concern'      => $request->concern,
        'notes'        => $request->notes,
        'date'         => $request->date,
        'status'       => 'upcoming',
    ]);

    return redirect()->route('counselor.sessions') // make sure this points to index
                     ->with('success', 'Session recorded successfully!');
}

}
