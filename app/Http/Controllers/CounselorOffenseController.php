<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Offense;

class CounselorOffenseController extends Controller
{
    public function index()
    {
        $offenses = Offense::with('student')->orderBy('date', 'desc')->get();
        return view('counselor_offenses', compact('offenses'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('counselor_create_offenses', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'offense' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Offense::create($validated);

        return redirect()->route('counselor.offenses')
            ->with('success', 'Offense created successfully.');
    }

    public function edit(Offense $offense)
    {
        $students = User::where('role', 'student')->get();
        return view('counselor_edit_offense', compact('offense', 'students'));
    }

    public function update(Request $request, Offense $offense)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'offense' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $offense->update($validated);

        return redirect()->route('counselor.offenses')
            ->with('success', 'Offense updated successfully.');
    }

    public function destroy(Offense $offense)
    {
        $offense->delete();
        return redirect()->route('counselor.offenses')
            ->with('success', 'Offense deleted successfully.');
    }
}
