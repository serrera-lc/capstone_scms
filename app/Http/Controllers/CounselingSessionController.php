<?php

namespace App\Http\Controllers;

use App\Models\CounselingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CounselingSessionController extends Controller
{
    public function index()
    {
        $counselorId = 1; // Replace with auth()->id() once login is ready

        $sessions = CounselingSession::with('student')
            ->where('counselor_id', $counselorId)
            ->latest()
            ->get();

        // Students for dropdown
        $students = User::where('role', 'student')->get();

        return view('counselor_sessions', compact('sessions', 'students'));
    }

    public function create()
    {
        return view('counselor_session_form');
    }

    public function store(Request $request)
    {
        $counselorId = 1; // Replace with auth()->id() once login is ready

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'concern'    => 'required|string|max:255',
            'notes'      => 'nullable|string',
            'date'       => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
        ]);

        // Calculate duration
        $start = Carbon::parse($request->start_time);
        $end   = Carbon::parse($request->end_time);
        $duration = $start->diff($end)->format('%h hrs %i mins');

        CounselingSession::create([
            'student_id'   => $request->student_id,
            'counselor_id' => $counselorId,
            'concern'      => $request->concern,
            'notes'        => $request->notes,
            'date'         => $request->date,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'duration'     => $duration,
            'status'       => 'upcoming',
        ]);

        return redirect()->route('counselor.sessions')
                         ->with('success', 'Session recorded successfully!');
    }
}
