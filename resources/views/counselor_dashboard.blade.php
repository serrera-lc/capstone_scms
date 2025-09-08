<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Dashboard') - SCMS</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            font-family: 'Google Sans', 'Segoe UI', sans-serif;
            background: #f9f9fb;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 20px;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .sidebar h4 {
            font-weight: 700;
            text-align: center;
            color: #1a73e8;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .sidebar .nav-link {
            color: #444;
            margin-bottom: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #e8f0fe;
            color: #1a73e8;
            font-weight: 600;
        }

        .sidebar form button {
            margin-top: auto;
            background: #f8f9fa;
            border: none;
            color: #444;
            font-weight: 600;
            border-radius: 10px;
            transition: background 0.2s ease;
        }

        .sidebar form button:hover {
            background: #e8f0fe;
            color: #1a73e8;
        }

        /* Main Content */
        .content {
            flex: 1;
            margin-left: 240px;
            padding: 25px;
        }

        /* Top Header */
        .top-header {
            background: #fff;
            border-radius: 12px;
            padding: 20px 25px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }

        .top-header h3 {
            font-weight: 700;
            color: #202124;
        }

        .top-header span {
            background: #1a73e8;
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        /* Stats Cards */
        .card-stat {
            border-radius: 16px;
            padding: 18px;
            color: #fff;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            transition: transform 0.2s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .card-stat i {
            font-size: 2rem;
            opacity: 0.2;
            position: absolute;
            bottom: 15px;
            right: 15px;
        }

        .gradient-blue { background: linear-gradient(135deg, #4285f4, #1a73e8); }
        .gradient-green { background: linear-gradient(135deg, #34a853, #0f9d58); }
        .gradient-orange { background: linear-gradient(135deg, #fbbc05, #e67e22); }
        .gradient-red { background: linear-gradient(135deg, #ea4335, #c5221f); }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 5px;
        }

        /* Tables */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        .card-header {
            background: #fff;
            font-weight: 700;
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 1rem;
        }

        table {
            font-size: 14px;
        }

        .table thead th {
            background: #f8f9fa;
            font-weight: 600;
            color: #5f6368;
        }

        .table tbody tr:hover {
            background: #f1f3f4;
            transition: 0.2s;
        }

        .badge {
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 12px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <h4>SCMS</h4>
        <a href="{{ route('counselor.dashboard') }}" class="nav-link {{ request()->routeIs('counselor.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('counselor.sessions') }}" class="nav-link {{ request()->routeIs('counselor.sessions*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Sessions
        </a>
        <a href="{{ route('counselor.appointments') }}" class="nav-link {{ request()->routeIs('counselor.appointments*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Appointments
        </a>
        <a href="{{ route('counselor.offenses') }}" class="nav-link {{ request()->routeIs('counselor.offenses') ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle"></i> Offenses
        </a>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button class="btn w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="top-header">
            <h3>@yield('page-title', 'Dashboard')</h3>
            <span>👋 Welcome, {{ auth()->user()->name }}</span>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card-stat gradient-blue">
                    <div>Upcoming Appointments</div>
                    <div class="stat-value">{{ $upcomingAppointmentsCount }}</div>
                    <i class="bi bi-calendar-event"></i>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card-stat gradient-green">
                    <div>Students Monitored</div>
                    <div class="stat-value">{{ $studentsMonitoredCount }}</div>
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card-stat gradient-orange">
                    <div>Sessions Today</div>
                    <div class="stat-value">{{ $sessionsTodayCount }}</div>
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card-stat gradient-red">
                    <div>Completed Sessions</div>
                    <div class="stat-value">{{ $completedSessionsCount }}</div>
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>

        <!-- Recent Sessions -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header"><i class="bi bi-journal-text"></i> Recent Sessions</div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Counselor</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSessions as $session)
                            <tr>
                                <td>{{ $session->student?->name ?? 'No Student' }}</td>
                                <td>{{ $session->counselor?->name ?? 'No Counselor' }}</td>
                                <td>{{ $session->date }}</td>
                                <td>
                                    <span class="badge bg-{{ $session->status === 'completed' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($session->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header"><i class="bi bi-calendar-check"></i> Upcoming Appointments</div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Counselor</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->student?->name ?? 'No Student' }}</td>
                                <td>{{ $appointment->counselor?->name ?? 'No Counselor' }}</td>
                                <td>{{ $appointment->date }}</td>
                                <td>{{ $appointment->time }}</td>
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
</body>
</html>
