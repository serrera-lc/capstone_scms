<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CounselingSession;
use App\Models\Offense;

class ReportController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $totalAppointments = Appointment::count();
        $totalSessions     = CounselingSession::count();
        $totalOffenses     = Offense::count();

        return view('reports', compact('totalAppointments','totalSessions','totalOffenses'));
    }
}
