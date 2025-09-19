@extends('layouts')

@section('page-title', 'Student Dashboard')

@section('content')
<div class="row g-4">
    {{-- Left side: Stats + Notifications --}}
    <div class="col-lg-8">

        {{-- Stats Cards --}}
        <div class="row g-4 mb-4">
            @php
                use Carbon\Carbon;
                $nextAppointment = \App\Models\Appointment::where('student_id', auth()->id())
                                    ->where('date', '>=', now()->toDateString())
                                    ->orderBy('date')
                                    ->orderBy('time')
                                    ->first();
                $totalSessions = \App\Models\CounselingSession::where('student_id', auth()->id())->count();
                $totalFeedbacks = \App\Models\Feedback::where('student_id', auth()->id())->count();
            @endphp

            <div class="col-md-4">
                <div class="card google-card p-4 text-center" style="background: #FCE4EC;">
                    <div class="small text-muted">Next Appointment</div>
                    <div class="fw-bold fs-6 mt-2">
                        @if($nextAppointment)
                            {{ Carbon::parse($nextAppointment->date)->format('M d, Y') }}
                            <br>
                            <small class="text-pink">{{ Carbon::parse($nextAppointment->time)->format('g:i A') }}</small>
                        @else
                            <span class="text-danger">No upcoming</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card google-card p-4 text-center" style="background: #F8BBD0;">
                    <div class="small text-muted">Total Sessions</div>
                    <div class="fw-bold fs-4 mt-2">{{ $totalSessions }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card google-card p-4 text-center" style="background: #FCE4EC;">
                    <div class="small text-muted">Feedback Given</div>
                    <div class="fw-bold fs-4 mt-2">{{ $totalFeedbacks }}</div>
                </div>
            </div>
        </div>

        {{-- Notifications --}}
        <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white">
            <h5 class="fw-bold mb-3 text-pink">Notifications</h5>
            <ul class="list-group list-group-flush">
                @forelse(\App\Models\Notification::where('student_id', auth()->id())->latest()->take(5)->get() as $note)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $note->message }}
                        <span class="text-muted small">{{ $note->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted">
                        No new notifications
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Right side: Quick Actions --}}
    <div class="col-lg-4">
        <h5 class="fw-bold mb-3 text-pink">⚡ Quick Actions</h5>
        <div class="d-grid gap-3">
            <a href="{{ route('student.appointment_form') }}" 
               class="card google-action-card text-center text-decoration-none p-4">
                <i class="bi bi-calendar-plus fs-1 mb-2 text-success"></i>
                <div class="fw-semibold">Request Appointment</div>
            </a>

            <a href="{{ route('student.appointments') }}" 
               class="card google-action-card text-center text-decoration-none p-4">
                <i class="bi bi-card-checklist fs-1 mb-2 text-primary"></i>
                <div class="fw-semibold">View Appointments</div>
            </a>

            <a href="{{ route('student.feedback') }}" 
               class="card google-action-card text-center text-decoration-none p-4">
                <i class="bi bi-chat-dots fs-1 mb-2 text-warning"></i>
                <div class="fw-semibold">Give Feedback</div>
            </a>

            <a href="{{ route('student.profile') }}" 
               class="card google-action-card text-center text-decoration-none p-4">
                <i class="bi bi-person-circle fs-1 mb-2 text-pink"></i>
                <div class="fw-semibold">Manage Profile</div>
            </a>
        </div>
    </div>
</div>

{{-- Styles specific for cards --}}
<style>
.google-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease-in-out;
}
.google-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.google-action-card {
    background-color: #FFFFFF;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease-in-out;
    color: #202124;
}
.google-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}
.text-pink { color: #d63384; }
</style>
@endsection
