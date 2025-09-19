@extends('layout')

@section('title', 'Admin Analytics')

@section('content')
<div class="container top-bar">
    


</div>

<!-- Content -->
<div class="container py-4" style="max-width: 1400px;">
    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card bg-student">
                <div>
                    <h6>Students</h6>
                    <h2 class="fw-bold">{{ $totalStudents }}</h2>
                </div>
                <i class="bi bi-people stat-icon fs-2"></i>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card bg-counselor">
                <div>
                    <h6>Counselors</h6>
                    <h2 class="fw-bold">{{ $totalCounselors }}</h2>
                </div>
                <i class="bi bi-person-badge stat-icon fs-2"></i>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card bg-appointments">
                <div>
                    <h6>Appointments</h6>
                    <h2 class="fw-bold">{{ $totalAppointments }}</h2>
                </div>
                <i class="bi bi-calendar-check stat-icon fs-2"></i>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card bg-offenses">
                <div>
                    <h6>Offenses</h6>
                    <h2 class="fw-bold">{{ $totalOffenses }}</h2>
                </div>
                <i class="bi bi-exclamation-octagon stat-icon fs-2"></i>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card rounded-4 border-0">
                <div class="card-header"><i class="bi bi-graph-up-arrow"></i> Monthly Appointments</div>
                <div class="card-body"><canvas id="appointmentsChart" height="280"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card rounded-4 border-0">
                <div class="card-header"><i class="bi bi-pie-chart"></i> Appointment Status</div>
                <div class="card-body"><canvas id="statusChart" height="280"></canvas></div>
            </div>
        </div>
    </div>

    <!-- More Charts -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card rounded-4 border-0">
                <div class="card-header"><i class="bi bi-people-fill"></i> Student Distribution</div>
                <div class="card-body"><canvas id="studentChart" height="280"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card rounded-4 border-0">
                <div class="card-header"><i class="bi bi-person-workspace"></i> Counselor Workload</div>
                <div class="card-body"><canvas id="counselorChart" height="280"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card rounded-4 border-0">
                <div class="card-header"><i class="bi bi-exclamation-triangle"></i> Monthly Offense Reports</div>
                <div class="card-body"><canvas id="offenseChart" height="280"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card rounded-4 border-0">
                <div class="card-header"><i class="bi bi-chat-dots"></i> Feedback Ratings</div>
                <div class="card-body"><canvas id="feedbackChart" height="280"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Appointments
    new Chart(document.getElementById('appointmentsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyAppointments->toArray() ?? [])) !!},
            datasets: [{
                label: 'Appointments',
                data: {!! json_encode(array_values($monthlyAppointments->toArray() ?? [])) !!},
                backgroundColor: '#1a73e8',
                borderRadius: 8
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Appointment Status
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Approved', 'Pending', 'Rejected'],
            datasets: [{
                data: [{{ $completedAppointments }}, {{ $pendingAppointments }}, {{ $rejectedAppointments }}],
                backgroundColor: ['#34a853', '#fbbc04', '#ea4335']
            }]
        },
        options: { responsive: true }
    });

    // Student Distribution
    new Chart(document.getElementById('studentChart'), {
        type: 'pie',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [{{ $activeStudents ?? 0 }}, {{ $inactiveStudents ?? 0 }}],
                backgroundColor: ['#1a73e8', '#dadce0']
            }]
        }
    });

    // Counselor Workload
    new Chart(document.getElementById('counselorChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($counselorNames ?? []) !!},
            datasets: [{
                label: 'Appointments Handled',
                data: {!! json_encode($counselorAppointments ?? []) !!},
                backgroundColor: '#34a853',
                borderRadius: 6
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Offense Trend
    new Chart(document.getElementById('offenseChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($monthlyOffenses->toArray() ?? [])) !!},
            datasets: [{
                label: 'Offenses',
                data: {!! json_encode(array_values($monthlyOffenses->toArray() ?? [])) !!},
                borderColor: '#ea4335',
                tension: 0.3,
                fill: false
            }]
        }
    });

    // Feedback Ratings
    new Chart(document.getElementById('feedbackChart'), {
        type: 'doughnut',
        data: {
            labels: ['Positive', 'Neutral', 'Negative'],
            datasets: [{
                data: [{{ $positiveFeedback ?? 0 }}, {{ $neutralFeedback ?? 0 }}, {{ $negativeFeedback ?? 0 }}],
                backgroundColor: ['#1a73e8', '#fbbc04', '#ea4335']
            }]
        }
    });

    
    
</script>
@endpush
