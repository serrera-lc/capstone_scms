<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Admin Dashboard') - SCMS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fb;
            margin: 0;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: #fff;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            z-index: 1000;
        }

        .top-navbar h4 {
            font-weight: 700;
            color: #202124;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #fff;
            padding: 20px 15px;
            height: calc(100vh - 70px);
            position: fixed;
            top: 70px;
            left: 0;
            border-right: 1px solid #e5e5e5;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .sidebar h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #1a73e8;
            text-align: center;
        }

        .sidebar .nav-link {
            color: #5f6368;
            padding: 12px 15px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #e8f0fe;
            color: #1a73e8;
        }

        /* Main Content */
        .content {
            margin-left: 240px;
            padding: 100px 25px 40px;
        }

        /* KPI Cards */
        .card-stat {
            border-radius: 12px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.2s ease;
        }

        .card-stat:hover {
            transform: scale(1.03);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #202124;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 500;
            color: #5f6368;
        }

        /* Chart Cards */
        .chart-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Tables */
        .table thead th {
            background-color: #f1f3f4;
            font-weight: 600;
        }

        .badge {
            font-size: 0.85rem;
            border-radius: 6px;
            padding: 6px 10px;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
                border-right: none;
                display: flex;
                flex-direction: row;
                justify-content: space-around;
            }

            .content {
                margin-left: 0;
                padding: 100px 15px;
            }

            .sidebar .nav-link {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <div class="top-navbar">
        <h4>SCMS Admin Dashboard</h4>
        <!-- Welcome Button Trigger for Modal -->
        <button type="button" class="btn btn-light border rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
            👋 Welcome, {{ auth()->user()->name }}
        </button>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <p class="fs-5 mb-3">
                        Are you sure you want to log out, <strong>{{ auth()->user()->name }}</strong>?
                    </p>
                    <i class="bi bi-box-arrow-right text-danger" style="font-size: 45px;"></i>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Close
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-box-arrow-right"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <h4>SCMS</h4>
            <a href="{{ url('/admin_dashboard') }}" class="nav-link {{ request()->is('admin_dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ url('/admin_users') }}" class="nav-link {{ request()->is('admin_users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Manage Users
            </a>
            <a href="{{ route('admin.appointments') }}" class="nav-link {{ request()->is('admin/appointments*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Appointments
            </a>
            <a href="{{ url('/admin_reports') }}" class="nav-link {{ request()->is('admin_reports*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Reports
            </a>
            <a href="{{ route('admin.feedbacks') }}" class="nav-link {{ request()->is('admin_feedbacks*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i> Feedbacks
            </a>
            <a href="{{ url('/admin_analytics') }}" class="nav-link {{ request()->is('admin_analytics*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Analytics
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- KPI Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card-stat">
                    <div class="stat-label">Students</div>
                    <div class="stat-value">{{ \App\Models\User::where('role','student')->count() }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat">
                    <div class="stat-label">Counselors</div>
                    <div class="stat-value">{{ \App\Models\User::where('role','counselor')->count() }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat">
                    <div class="stat-label">Pending Appointments</div>
                    <div class="stat-value">{{ \App\Models\Appointment::where('status','pending')->count() }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat">
                    <div class="stat-label">Pending Reports</div>
                    <div class="stat-value">{{ \App\Models\Offense::where('status','pending')->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="chart-card">
                    <h5>Appointments This Week</h5>
                    <canvas id="appointmentsChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <h5>Reports Breakdown</h5>
                    <canvas id="reportsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Appointments Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Recent Appointments</div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover" id="appointments-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Counselor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Appointment::with(['student','counselor'])->orderBy('date','desc')->take(5)->get() as $appointment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $appointment->student->name ?? 'N/A' }}</td>
                                <td>{{ $appointment->counselor->name ?? 'N/A' }}</td>
                                <td>{{ $appointment->date }}</td>
                                <td>{{ $appointment->time }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $appointment->status == 'pending' ? 'bg-warning text-dark' : '' }}
                                        {{ $appointment->status == 'completed' ? 'bg-success' : '' }}
                                        {{ $appointment->status == 'cancelled' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            $('#appointments-table').DataTable();
        });

        // Chart.js - Appointments
        new Chart(document.getElementById('appointmentsChart'), {
            type: 'line',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [{
                    label: 'Appointments',
                    data: [3, 7, 4, 5, 8, 6, 4],
                    borderColor: '#1a73e8',
                    backgroundColor: 'rgba(26, 115, 232, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });

        // Chart.js - Reports
        new Chart(document.getElementById('reportsChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Resolved', 'Dismissed'],
                datasets: [{
                    data: [12, 8, 5],
                    backgroundColor: ['#fbbc04', '#34a853', '#ea4335']
                }]
            }
        });
    </script>
</body>
</html>
