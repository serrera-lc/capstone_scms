<?php

namespace App\Http\Controllers;

use App\Models\Offense;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class OffenseController extends Controller
{
    // Show all offenses (counselor view)
   public function index()
{
    if (auth()->user()->role !== 'counselor') {
        abort(403, 'Unauthorized');
    }

    $offenses = Offense::with('student')->get();
    $students = \App\Models\User::where('role', 'student')->get();

    return view('counselor_offenses', compact('offenses', 'students'));
}


    // Store a new offense
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'counselor') {
            abort(403, 'Unauthorized');
        }

        // Validate inputs
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'offense'    => 'required|string|max:255',
            'remarks'    => 'nullable|string',
            'date'       => 'required|date',
        ]);

        // Create the offense record
        $offense = Offense::create([
            'student_id' => $request->student_id,
            'offense'    => $request->offense,
            'remarks'    => $request->remarks,
            'date'       => $request->date,
        ]);

        // Log the action
        Log::create([
            'user_id' => auth()->id(),
            'action'  => "Recorded offense '{$offense->offense}' for student ID {$offense->student_id} on {$offense->date}",
        ]);

        return redirect()->route('counselor.offenses')
                         ->with('success', 'Offense recorded successfully!');
    }
}
