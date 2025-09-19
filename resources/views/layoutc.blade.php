<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Counselor Dashboard - SCMS')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fdfdfd;
        }
        /* Top Navbar */
        .top-navbar {
            background: #f8bbd0; /* light pink */
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0; left: 0; right: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            z-index: 1000;
            color: #880e4f;
        }
        .top-navbar h4 {
            font-weight: 700;
            color: #880e4f;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #fff;
            padding: 20px 15px;
            height: calc(100vh - 70px);
            position: fixed;
            top: 70px; left: 0;
            border-right: 1px solid #f8bbd0;
            display: flex;
            flex-direction: column;
            transition: .3s;
        }
        .sidebar h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #d63384;
            text-align: center;
        }
        .sidebar .nav-link {
            color: #555;
            padding: 12px 15px;
            border-radius: 10px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: .3s;
            margin-bottom: 10px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f8bbd0;
            color: #880e4f;
            font-weight: 600;
        }
        .sidebar.collapsed { width: 70px; overflow: hidden; }
        .sidebar.collapsed h4,
        .sidebar.collapsed .nav-link span { display: none; }

        /* Main Content */
        .content {
            margin-left: 240px;
            padding: 100px 25px 40px;
            transition: margin-left .3s;
        }
        .content.expanded { margin-left: 70px !important; }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 16px;
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #f8bbd0;
            font-weight: 600;
            color: #d63384;
        }
        .badge {
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .content { margin-left: 0 !important; padding: 100px 15px; }
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <div class="top-navbar">
        <button class="btn btn-light border rounded-circle me-3" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h4>@yield('page-title', 'Counselor Dashboard')</h4>
        <button type="button" class="btn btn-light border rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
            👋 Welcome, {{ auth()->user()->name }}
        </button>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg">
                <div class="modal-header bg-light text-dark">
                    <h5 class="modal-title">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure you want to log out, <strong>{{ auth()->user()->name }}</strong>?</p>
                    <i class="bi bi-box-arrow-right text-danger" style="font-size: 45px;"></i>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
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
    <div class="sidebar" id="sidebar">
        <h4>SCMS</h4>
        <a href="{{ route('counselor.dashboard') }}" class="nav-link {{ request()->routeIs('counselor.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('counselor.sessions') }}" class="nav-link {{ request()->routeIs('counselor.sessions*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> <span>Sessions</span>
        </a>
        <a href="{{ route('counselor.appointments') }}" class="nav-link {{ request()->routeIs('counselor.appointments*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> <span>Appointments</span>
        </a>
        <a href="{{ route('counselor.offenses') }}" class="nav-link {{ request()->routeIs('counselor.offenses*') ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle"></i> <span>Offenses</span>
        </a>
        <a href="{{ route('counselor.reports') }}" class="nav-link {{ request()->routeIs('counselor.reports*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i> <span>Reports</span>
        </a>
        <a href="{{ route('counselor.notifications') }}" class="nav-link {{ request()->routeIs('counselor.notifications*') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> <span>Notifications</span>
        </a>
        <a href="{{ route('counselor.audit') }}" class="nav-link {{ request()->routeIs('counselor.audit*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> <span>Audit Logs</span>
        </a>
    </div>


    <!-- Main Content -->
    <div class="content" id="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
            }
        });
    </script>
</body>
</html>
