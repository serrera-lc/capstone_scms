<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\CounselingSession;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Fetch next appointment
        $nextAppointment = Appointment::where('student_id', auth()->id())
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('time')
            ->first();

        $totalSessions = CounselingSession::where('student_id', auth()->id())->count();

        return view('student_dashboard', compact('nextAppointment', 'totalSessions'));
    }

    public function appointments()
    {
        $appointments = Appointment::with('counselor')
            ->where('student_id', auth()->id())
            ->latest()
            ->get();

        return view('student_appointments', compact('appointments'));
    }
}
