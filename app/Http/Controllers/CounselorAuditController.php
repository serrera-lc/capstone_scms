<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog; // assuming you have an AuditLog model

class CounselorAuditController extends Controller
{
    public function index()
    {
        $counselorId = auth()->id();

        // Fetch logs for the current counselor
        $audits = AuditLog::with('user')
            ->where('user_id', $counselorId)
            ->latest()
            ->get();

        return view('counselor_audit', compact('audits'));
    }
}
