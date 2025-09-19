<?php

namespace App\Http\Controllers;

use App\Models\Offense;
use App\Models\Appointment;
use App\Models\CounselingSession;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // --- Misconduct Reports ---
        $reports = Offense::with('student')->latest()->get();

        // --- System Usage ---
        $totalUsers   = User::count();
        $activeUsers  = User::where('last_login_at', '>=', now()->subMonth())->count();

        // --- Appointments, Sessions, Offenses ---
        $totalAppointments = Appointment::count();
        $totalSessions     = CounselingSession::count();
        $totalOffenses     = Offense::count();

        // --- Counselor Performance ---
        $counselorPerformance = User::withCount('counselingSessions')
            ->where('role', 'counselor')
            ->get();

        // --- Student Engagement (last 30 days) ---
        $studentEngagement = [
            'appointments' => Appointment::where('created_at', '>=', now()->subDays(30))->count(),
            'sessions'     => CounselingSession::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin_reports', compact(
            'reports',
            'totalUsers',
            'activeUsers',
            'totalAppointments',
            'totalSessions',
            'totalOffenses',
            'counselorPerformance',
            'studentEngagement'
        ));
    }

    public function update(Request $request, $id)
    {
        $report = Offense::findOrFail($id);

        $validated = $request->validate([
            'offense' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'status'  => 'required|in:pending,reviewed,resolved',
        ]);

        $report->update($validated);

        return redirect()->route('admin.reports')->with('success', 'Report updated successfully.');
    }

    public function destroy($id)
    {
        $report = Offense::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.reports')->with('success', 'Report deleted successfully.');
    }
}
