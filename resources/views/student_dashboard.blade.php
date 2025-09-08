@extends('clean')

@section('page-title', 'Student Dashboard')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0" style="color:#202124;">🎓 Student Dashboard</h3>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-light border px-3 shadow-sm hover-effect">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-5">
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

        {{-- Next Appointment --}}
        <div class="col-md-4">
            <div class="card google-card p-4 text-center" style="background: #E3F2FD;">
                <div class="small text-muted">Next Appointment</div>
                <div class="fw-bold fs-5 mt-2">
                    @if($nextAppointment)
                        {{ Carbon::parse($nextAppointment->date)->format('M d, Y') }}
                        <br>
                        <small class="text-primary">{{ Carbon::parse($nextAppointment->time)->format('g:i A') }}</small>
                    @else
                        <span class="text-danger">No upcoming appointment</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Total Sessions --}}
        <div class="col-md-4">
            <div class="card google-card p-4 text-center" style="background: #E8F5E9;">
                <div class="small text-muted">Total Sessions</div>
                <div class="fw-bold fs-4 mt-2">{{ $totalSessions }}</div>
            </div>
        </div>

        {{-- Feedback Given --}}
        <div class="col-md-4">
            <div class="card google-card p-4 text-center" style="background: #FFF8E1;">
                <div class="small text-muted">Feedback Given</div>
                <div class="fw-bold fs-4 mt-2">{{ $totalFeedbacks }}</div>
            </div>
        </div>
    </div>

    {{-- Sessions Chart --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 mb-5 bg-white">
        <h5 class="fw-bold mb-3" style="color:#202124;">📈 Sessions Over Time</h5>
        <canvas id="sessionsChart" height="100"></canvas>
    </div>

    {{-- Quick Actions --}}
    <h5 class="fw-bold mb-3" style="color:#202124;">⚡ Quick Actions</h5>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('student.appointment_form') }}" 
               class="card google-action-card text-center text-decoration-none p-4">
                <i class="bi bi-calendar-plus fs-1 mb-2 text-success"></i>
                <div class="fw-semibold">Request Appointment</div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('student.appointments') }}" 
               class="card google-action-card text-center text-decoration-none p-4">
                <i class="bi bi-card-checklist fs-1 mb-2 text-primary"></i>
                <div class="fw-semibold">View Appointments</div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('student.feedback') }}" 
               class="card google-action-card text-center text-decoration-none p-4">
                <i class="bi bi-chat-dots fs-1 mb-2 text-warning"></i>
                <div class="fw-semibold">Give Feedback</div>
            </a>
        </div>
    </div>

</div>

{{-- Extra CSS for Google Classroom Design --}}
<style>
    /* General Look */
    body {
        background-color: #F8F9FA;
        font-family: 'Roboto', sans-serif;
    }

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
        cursor: pointer;
        color: #202124;
    }

    .google-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    }

    .hover-effect {
        transition: 0.3s;
    }

    .hover-effect:hover {
        background-color: #F1F3F4;
    }
</style>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('sessionsChart').getContext('2d');

    const labels = {!! json_encode(\App\Models\CounselingSession::where('student_id', auth()->id())->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))->toArray()) !!};
    const data = {!! json_encode(\App\Models\CounselingSession::where('student_id', auth()->id())->pluck('id')->toArray()) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sessions',
                data: data.map(() => 1),
                fill: true,
                backgroundColor: 'rgba(66, 133, 244, 0.2)',
                borderColor: '#4285F4',
                tension: 0.3,
                pointBackgroundColor: '#4285F4'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, precision:0, stepSize:1 },
                x: { ticks: { maxRotation: 0, minRotation: 0 } }
            }
        }
    });
</script>
@endsection
