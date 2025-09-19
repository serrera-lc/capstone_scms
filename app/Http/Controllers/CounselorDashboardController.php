<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\CounselingSession;
use App\Models\Offense;
use App\Models\Notification;
use App\Models\AuditLog;
use Carbon\Carbon;

class CounselorDashboardController extends Controller
{
    public function index()
    {
        $counselorId = auth()->id();

        // === Stats ===
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

        // === Recent Sessions ===
        $recentSessions = CounselingSession::with(['student', 'counselor'])
            ->where('counselor_id', $counselorId)
            ->latest()
            ->take(5)
            ->get();

        // === Upcoming Appointments ===
        $appointments = Appointment::with(['student', 'counselor'])
            ->where('counselor_id', $counselorId)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->take(5)
            ->get();

        // === Recent Offenses ===
        $offenses = Offense::with('student')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // === Notifications ===
        $notifications = Notification::latest()
            ->take(5)
            ->get();

        // === Audit Logs ===
        $auditLogs = AuditLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        // === Stats Summary for Reports ===
        $stats = [
            'total_sessions' => CounselingSession::where('counselor_id', $counselorId)->count(),
            'total_appointments' => Appointment::where('counselor_id', $counselorId)->count(),
            'total_offenses' => Offense::count(),
        ];

        return view('counselor_dashboard', compact(
            'upcomingAppointmentsCount',
            'studentsMonitoredCount',
            'sessionsTodayCount',
            'completedSessionsCount',
            'recentSessions',
            'appointments',
            'offenses',
            'notifications',
            'auditLogs',
            'stats'
        ));
    }
}
