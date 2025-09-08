<?php

namespace App\Http\Controllers;

use App\Models\Offense;
use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    // Show all reports
    public function index()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $reports = Offense::with('student')->latest()->get();
        return view('admin_reports', compact('reports'));
    }

    // Update report status
    public function update(Request $request, Offense $report)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,reviewed,resolved',
        ]);

        $report->status = $request->status;
        $report->save();

        return redirect()->back()->with('success', 'Report status updated successfully!');
    }

    // Delete a report
    public function destroy(Offense $report)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $report->delete();
        return redirect()->back()->with('success', 'Report deleted successfully!');
    }
}
