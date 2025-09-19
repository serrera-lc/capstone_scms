<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Admin Dashboard') - SCMS</title>

    @extends('layout')

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
            background-color: #fdf3f7; /* soft pink background */
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
            color: #e91e63; /* pink */
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
            border-right: 1px solid #f3c5d3;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .sidebar h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #e91e63;
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
            background-color: #fce4ec; /* light pink */
            color: #e91e63;
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
            color: #e91e63;
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
            background-color: #fce4ec; /* pink table header */
            font-weight: 600;
            color: #e91e63;
        }

        .badge {
            font-size: 0.85rem;
            border-radius: 6px;
            padding: 6px 10px;
        }

        /* Modal headers */
        .modal-header.bg-primary,
        .modal-header.bg-success,
        .modal-header.bg-warning,
        .modal-header.bg-danger {
            background-color: #e91e63 !important;
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
        <div class="modal-content rounded-4 shadow-lg border-0">
            
            <!-- Modal Header -->
            <div class="modal-header text-white rounded-top-4" style="background-color: #e83e8c;">
                <h5 class="modal-title fw-bold" id="logoutModalLabel">
                    Confirm Logout
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center py-4">
                <p class="fs-5 mb-3">
                    Are you sure you want to log out, 
                    <strong>{{ auth()->user()->name }}</strong>?
                </p>
                <i class="bi bi-box-arrow-right" style="font-size: 3rem; color: #e83e8c;"></i>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancel
                </button>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn px-4 text-white" style="background-color: #e83e8c;">
                        <i class="bi bi-box-arrow-right"></i> Log Out
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>


  
    
    <!-- Main Content -->
    <div class="content">
        <!-- KPI Cards -->
<div class="row mb-4">
    <!-- Students -->
    <div class="col-md-3">
        <div class="card-stat" data-bs-toggle="modal" data-bs-target="#studentsModal" style="cursor:pointer;">
            <div class="stat-label">Students</div>
            <div class="stat-value">{{ \App\Models\User::where('role','student')->count() }}</div>
        </div>
    </div>

    <!-- Counselors -->
    <div class="col-md-3">
        <div class="card-stat" data-bs-toggle="modal" data-bs-target="#counselorsModal" style="cursor:pointer;">
            <div class="stat-label">Counselors</div>
            <div class="stat-value">{{ \App\Models\User::where('role','counselor')->count() }}</div>
        </div>
    </div>

    <!-- Pending Appointments -->
    <div class="col-md-3">
        <div class="card-stat" data-bs-toggle="modal" data-bs-target="#appointmentsModal" style="cursor:pointer;">
            <div class="stat-label">Pending Appointments</div>
            <div class="stat-value">{{ \App\Models\Appointment::where('status','pending')->count() }}</div>
        </div>
    </div>

    <!-- Pending Reports -->
    <div class="col-md-3">
        <div class="card-stat" data-bs-toggle="modal" data-bs-target="#reportsModal" style="cursor:pointer;">
            <div class="stat-label">Pending Reports</div>
            <div class="stat-value">{{ \App\Models\Offense::where('status','pending')->count() }}</div>
        </div>
    </div>
</div>

<!-- STUDENTS MODAL -->
<div class="modal fade" id="studentsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">All Students</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-hover">
          <thead>
            <tr><th>#</th><th>Name</th><th>Email</th></tr>
          </thead>
          <tbody>
            @foreach(\App\Models\User::where('role','student')->get() as $student)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- COUNSELORS MODAL -->
<div class="modal fade" id="counselorsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">All Counselors</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-hover">
          <thead>
            <tr><th>#</th><th>Name</th><th>Email</th></tr>
          </thead>
          <tbody>
            @foreach(\App\Models\User::where('role','counselor')->get() as $counselor)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $counselor->name }}</td>
                <td>{{ $counselor->email }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- PENDING APPOINTMENTS MODAL -->
<div class="modal fade" id="appointmentsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Pending Appointments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-striped">
          <thead>
            <tr><th>#</th><th>Student</th><th>Counselor</th><th>Date</th><th>Time</th></tr>
          </thead>
          <tbody>
            @foreach(\App\Models\Appointment::where('status','pending')->with(['student','counselor'])->get() as $appointment)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $appointment->student->name ?? 'N/A' }}</td>
                <td>{{ $appointment->counselor->name ?? 'N/A' }}</td>
                <td>{{ $appointment->date }}</td>
                <td>{{ $appointment->time }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- PENDING REPORTS MODAL -->
<div class="modal fade" id="reportsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Pending Reports</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr><th>#</th><th>Student</th><th>Offense</th><th>Status</th></tr>
          </thead>
          <tbody>
            @foreach(\App\Models\Offense::where('status','pending')->with('student')->get() as $report)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $report->student->name ?? 'N/A' }}</td>
                <td>{{ $report->offense_type ?? 'N/A' }}</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
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
            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</td>
            <td>
                <span class="badge 
                    {{ $appointment->status === 'Pending' ? 'bg-warning text-dark' : '' }}
                    {{ $appointment->status === 'Approved' ? 'bg-success' : '' }}
                    {{ $appointment->status === 'Rejected' ? 'bg-danger' : '' }}">
                    {{ $appointment->status }}
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
