<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\CounselingSession;
use Carbon\Carbon;

class CounselorDashboardController extends Controller
{
    public function index()
    {
        $counselorId = auth()->id();

        // Stats
        $upcomingAppointmentsCount = Appointment::where('counselor_id', $counselorId)
            ->where('date', '>=', now()->toDateString())
            ->count();

        $studentsMonitoredCount = CounselingSession::where('counselor_id', $counselorId)
            ->distinct('student_id')
            ->count('student_id');

        $sessionsTodayCount = CounselingSession::where('counselor_id', $counselorId)
            ->where('date', now()->toDateString())
            ->count();

        $completedSessionsCount = CounselingSession::where('counselor_id', $counselorId)
            ->where('status', 'completed')
            ->count();

        $counselorId = auth()->id();

$recentSessions = CounselingSession::with(['student', 'counselor'])
    ->where('counselor_id', $counselorId)
    ->latest()
    ->take(10)
    ->get();

$appointments = Appointment::with(['student', 'counselor'])
    ->where('counselor_id', $counselorId)
    ->whereNotNull('counselor_id')
    ->where('date', '>=', now()->toDateString())
    ->orderBy('date', 'asc')
    ->get();



        return view('counselor_dashboard', compact(
            'upcomingAppointmentsCount',
            'studentsMonitoredCount',
            'sessionsTodayCount',
            'completedSessionsCount',
            'recentSessions',
            'appointments'
        ));
    }
}
