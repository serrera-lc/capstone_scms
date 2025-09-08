<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* === Google Classroom Look === */
        body {
            background-color: #f1f3f4;
            font-family: "Google Sans", "Roboto", sans-serif;
            transition: background 0.3s, color 0.3s;
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 20px 0 30px 0;
        }

        /* Title Styling */
        .top-bar h5 {
            font-weight: 600;
            color: #202124;
            margin: 0;
            text-align: center;
            flex-grow: 1;
        }

        /* Dark Mode Button */
        .gc-btn {
            background: #fff;
            color: #1a73e8;
            border-radius: 30px;
            padding: 6px 16px;
            font-weight: 500;
            transition: 0.2s;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .gc-btn:hover {
            background: #e8f0fe;
        }

        /* Back Button */
        .back-btn {
            border-radius: 30px;
            padding: 6px 18px;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease-in-out;
            background: #fff;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        /* Stat Cards */
        .stat-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.4rem;
            border-radius: 14px;
            color: #fff;
        }

        .bg-student { background: linear-gradient(135deg, #34a853, #81c995); }
        .bg-counselor { background: linear-gradient(135deg, #1a73e8, #7baaf7); }
        .bg-appointments { background: linear-gradient(135deg, #fbbc04, #ffd666); color: #000; }
        .bg-offenses { background: linear-gradient(135deg, #ea4335, #f28b82); }

        /* Dark Mode */
        .dark-mode {
            background-color: #202124 !important;
            color: #e8eaed !important;
        }

        .dark-mode .card {
            background-color: #2d2f33;
            color: #e8eaed;
            box-shadow: none;
        }

        .dark-mode .top-bar h5 {
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Top Bar with Buttons & Title -->
    <div class="container top-bar">
        <!-- Left: Dark Mode Button -->
        <button id="darkToggle" class="gc-btn d-flex align-items-center gap-2">
            <i class="bi bi-moon-stars"></i> Dark Mode
        </button>

        <!-- Center: Title -->
        <h5>📊 Admin Analytics</h5>

        <!-- Right: Back Button -->
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary back-btn">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
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

    <!-- Chart.js -->
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

        // Dark Mode Toggle
        const darkBtn = document.getElementById('darkToggle');
        darkBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            darkBtn.innerHTML = document.body.classList.contains('dark-mode')
                ? '<i class="bi bi-brightness-high"></i> Light Mode'
                : '<i class="bi bi-moon-stars"></i> Dark Mode';
        });
    </script>
</body>
</html>
