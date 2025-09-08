<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Appointment;
use App\Models\Feedback;
use App\Models\Offense;
use App\Models\User;
use App\Http\Controllers\CounselorDashboardController;
use App\Http\Controllers\CounselorOffenseController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\{
    AuthController,
    AppointmentController,
    CounselingSessionController,
    OffenseController,
    FeedbackController,
    ReportController,
    UserController,
    AnalyticsController
};

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Universal appointments route
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');

// Store new appointment (student)
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

// Update status (counselor)
Route::put('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

// Cancel appointment (student)
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

// ✅ Admin Dashboard → http://127.0.0.1:8000/admin_dashboard
Route::get('/admin_dashboard', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }
    return view('admin_dashboard');
})->name('admin.dashboard');

// ✅ Admin Users → http://127.0.0.1:8000/admin_users
Route::get('/admin_users', [UserController::class, 'index'])->name('admin.users');
Route::post('/admin_users', [UserController::class, 'store'])->name('admin.users.store');
Route::put('/admin_users/{user}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin_users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

// ✅ Admin Appointments → http://127.0.0.1:8000/admin_appointments
Route::get('/admin_appointments', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }
    $appointments = \App\Models\Appointment::with('student', 'counselor')->latest()->get();
    return view('admin_appointments', compact('appointments'));
})->name('admin.appointments');

Route::patch('/admin_appointments/{appointment}/status', function (Request $request, \App\Models\Appointment $appointment) {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }
    $request->validate(['status' => 'required|in:pending,approved,rejected']);
    $appointment->status = $request->status;
    $appointment->save();
    return redirect()->back()->with('success', 'Appointment status updated.');
})->name('admin.appointments.status');

// ✅ Admin Reports → http://127.0.0.1:8000/admin_reports
Route::get('/admin_reports', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }
    $reports = Offense::with('student')->latest()->get();
    return view('admin_reports', compact('reports'));
})->name('admin.reports');

Route::patch('/admin_reports/{report}', function (Request $request, Offense $report) {
    if (!auth()->check() || auth()->user()->role !== 'admin') abort(403);
    $report->status = $request->status;
    $report->save();
    return redirect()->back()->with('success', 'Report status updated.');
})->name('admin.reports.update');

Route::delete('/admin_reports/{report}', function (Offense $report) {
    if (!auth()->check() || auth()->user()->role !== 'admin') abort(403);
    $report->delete();
    return redirect()->back()->with('success', 'Report deleted successfully.');
})->name('admin.reports.destroy');

// ✅ Admin Analytics → http://127.0.0.1:8000/admin_analytics
Route::get('/admin_analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');



Route::prefix('counselor')->group(function () {

    // Dashboard
    Route::get('/dashboard', [CounselorDashboardController::class, 'index'])
        ->name('counselor.dashboard');

    // Counseling Sessions
    Route::get('/sessions', [CounselingSessionController::class, 'index'])
        ->name('counselor.sessions');
    Route::get('/session_form', [CounselingSessionController::class, 'create'])
        ->name('counselor.session_form');
    Route::post('/sessions', [CounselingSessionController::class, 'store'])
        ->name('counselor.sessions.store');

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->name('counselor.appointments');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
        ->name('counselor.appointments.status');

    // Offenses
    Route::get('/offenses', [CounselorOffenseController::class, 'index'])
        ->name('counselor.offenses');

    Route::get('/offenses/create', [CounselorOffenseController::class, 'create'])
        ->name('counselor.offenses.create');

    Route::post('/offenses', [CounselorOffenseController::class, 'store'])
        ->name('counselor.offenses.store');

    Route::get('/offenses/{offense}/edit', [CounselorOffenseController::class, 'edit'])
        ->name('counselor.offenses.edit');

    Route::put('/offenses/{offense}', [CounselorOffenseController::class, 'update'])
        ->name('counselor.offenses.update');

    Route::delete('/offenses/{offense}', [CounselorOffenseController::class, 'destroy'])
        ->name('counselor.offenses.destroy');
});


// Student Dashboard
Route::get('/student_dashboard', [StudentDashboardController::class, 'index'])
    ->name('student.dashboard');

// Student Appointments
Route::get('/student_appointments', [StudentDashboardController::class, 'appointments'])
    ->name('student.appointments');

// Appointment Form
Route::get('/student_appointment_form', [AppointmentController::class, 'create'])
    ->name('student.appointment_form');

Route::post('/student_appointments', [AppointmentController::class, 'store'])
    ->name('student.appointments.store');

// Cancel Appointment
Route::delete('/student_appointments/{appointment}', function (Appointment $appointment) {
    // Optional: remove auth checks if you don’t want middleware
    $appointment->delete();
    return redirect()->back()->with('success', 'Appointment canceled.');
})->name('student.appointments.destroy');

// Student Feedback
Route::get('/student_feedback', [FeedbackController::class, 'index'])->name('student.feedback');
Route::post('/student_feedback', [FeedbackController::class, 'store'])->name('student.feedback.store');

// Appointments
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/student_appointment_form', [AppointmentController::class, 'create'])->name('student.appointment_form');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

// Test Mail
Route::get('/test-mail', function () {
    Mail::raw('This is a test email using Mailtrap!', function ($message) {
        $message->to('test@example.com')
                ->subject('Test Mailtrap Email');
    });

    return 'Email sent!';
});

// Student feedback page
Route::get('/student_feedback', [FeedbackController::class, 'index'])->name('student.feedback');
Route::post('/student_feedback', [FeedbackController::class, 'store'])->name('student.feedback.store');

// Admin feedback page
Route::get('/admin_feedbacks', [FeedbackController::class, 'adminIndex'])->name('admin.feedbacks');


Route::post('/admin/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('admin.appointments.approve');
Route::post('/admin/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('admin.appointments.reject');
Route::get('/admin/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('admin.appointments.edit');
Route::put('/admin/appointments/{appointment}', [AppointmentController::class, 'update'])->name('admin.appointments.update');

// Admin routes for appointments
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments.index');
    Route::put('appointments/{appointment}', [App\Http\Controllers\AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('appointments/{appointment}', [App\Http\Controllers\AppointmentController::class, 'destroy'])->name('appointments.destroy');
});


