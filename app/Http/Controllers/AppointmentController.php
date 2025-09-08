<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentNotification; // <-- Add this

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            $appointments = Appointment::with('counselor')
                ->where('student_id', $user->id)
                ->latest()
                ->get();
            $view = 'student_appointments'; 
        } elseif ($user->role === 'counselor') {
            $appointments = Appointment::with('student')
                ->where('counselor_id', $user->id)
                ->latest()
                ->get();
            $view = 'counselor_appointments'; 
        } else {
            $appointments = Appointment::with(['student', 'counselor'])
                ->latest()
                ->get();
            $view = 'admin_appointments'; 
        }

        return view($view, compact('appointments'));
    }

    // Show appointment form
    public function create()
    {
        $counselors = User::where('role', 'counselor')->get();
        return view('student_appointment_form', compact('counselors'));
    }

    // Store new appointment
    public function store(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'date'         => 'required|date|after_or_equal:today',
            'time'         => 'required',
            'reason'       => 'required|string|max:255',
        ]);

        $appointment = Appointment::create([
            'student_id'   => Auth::id(),
            'counselor_id' => $request->counselor_id,
            'date'         => $request->date,
            'time'         => $request->time,
            'reason'       => $request->reason,
            'status'       => 'Pending',
        ]);

        // --- EMAIL NOTIFICATIONS ---
        $student = Auth::user();
        $counselor = User::find($request->counselor_id);

        // Send email to student
        if ($student->email) {
            Mail::to($student->email)->send(new AppointmentNotification($appointment));
        }

        // Send email to counselor
        if ($counselor && $counselor->email) {
            Mail::to($counselor->email)->send(new AppointmentNotification($appointment));
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment requested successfully! Emails sent.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
{
    $request->validate([
        'status' => 'required|in:Pending,Approved,Rejected',
    ]);

    $appointment->status = $request->status;
    $appointment->save();

    // --- EMAIL NOTIFICATION ON STATUS CHANGE ---
    $student = $appointment->student;

    if ($student && $student->email) {
        Mail::to($student->email)->send(new AppointmentNotification($appointment));
    }

    return redirect()->back()->with('success', 'Appointment status updated and student notified via email.');
}


    public function destroy(Appointment $appointment)
    {
        if (Auth::user()->role === 'student' && $appointment->student_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->delete();

        return redirect()->back()->with('success', 'Appointment canceled.');
    }

    public function approve(Appointment $appointment) {
    $appointment->status = 'Approved';
    $appointment->save();
    return back()->with('success', 'Appointment approved.');
}

public function reject(Appointment $appointment) {
    $appointment->status = 'Rejected';
    $appointment->save();
    return back()->with('success', 'Appointment rejected.');
}

public function edit(Appointment $appointment) {
    return view('admin.edit_appointment', compact('appointment'));
}

public function update(Request $request, Appointment $appointment) {
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'status' => 'required|in:Pending,Approved,Rejected',
    ]);
    $appointment->update($request->only('date','time','status'));
    return redirect()->route('admin.appointments.index')->with('success','Appointment updated.');
}

}
