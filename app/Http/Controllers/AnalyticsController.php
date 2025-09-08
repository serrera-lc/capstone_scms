<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Offense;
use App\Models\Feedback;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard.
     */
    public function index()
{
    // Check if the logged-in user is an admin
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized access.');
    }

    // Basic stats
    $totalStudents = User::where('role', 'student')->count();
    $totalCounselors = User::where('role', 'counselor')->count();
    $totalAppointments = Appointment::count();
    $completedAppointments = Appointment::where('status', 'approved')->count();
    $pendingAppointments = Appointment::where('status', 'pending')->count();
    $rejectedAppointments = Appointment::where('status', 'rejected')->count();
    $totalOffenses = Offense::count();
    $totalFeedbacks = Feedback::count();

    // Monthly appointment chart data
    $monthlyAppointments = Appointment::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // ✅ Monthly offenses chart data
    $monthlyOffenses = Offense::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    return view('admin_analytics', compact(
        'totalStudents',
        'totalCounselors',
        'totalAppointments',
        'completedAppointments',
        'pendingAppointments',
        'rejectedAppointments',
        'totalOffenses',
        'totalFeedbacks',
        'monthlyAppointments',
        'monthlyOffenses' // ✅ added here
    ));
}

}
