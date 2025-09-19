<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report; // make sure you have this model

class CounselorReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        $reports = $query->latest()->paginate(10);

        return view('counselor_reports', compact('reports'));
    }
}
