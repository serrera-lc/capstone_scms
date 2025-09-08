<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SCMS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { overflow-x: hidden; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            min-height: 100vh;
            background: #0d6efd;
            color: white;
            padding-top: 20px;
            position: fixed;
            width: 220px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            margin: 2px 0;
            border-radius: 5px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.2);
            font-weight: 600;
        }
        .content {
            margin-left: 220px;
            padding: 25px;
            background: #f8f9fa;
            min-height: 100vh;
        }
        .sidebar hr {
            border-top: 1px solid rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center fw-bold">SCMS</h4>
    <hr>
    <ul class="nav flex-column">

        {{-- ADMIN LINKS --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
            <li><a href="{{ url('admin_dashboard') }}" class="{{ request()->is('admin_dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="{{ url('admin_users') }}" class="{{ request()->is('users*') ? 'active' : '' }}"><i class="bi bi-people"></i> Users</a></li>
            <li><a href="{{ url('admin_reports') }}" class="{{ request()->is('reports*') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Reports</a></li>
        @endif

        {{-- COUNSELOR LINKS --}}
        @if(Auth::check() && Auth::user()->role === 'counselor')
            <li><a href="{{ url('counselor/dashboard') }}" class="{{ request()->is('counselor/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="{{ url('counselor/sessions') }}" class="{{ request()->is('counselor/sessions*') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Sessions</a></li>
            <li><a href="{{ url('counselor/offenses') }}" class="{{ request()->is('counselor/offenses*') ? 'active' : '' }}"><i class="bi bi-exclamation-triangle"></i> Offenses</a></li>
        @endif

        {{-- STUDENT LINKS --}}
        @if(Auth::check() && Auth::user()->role === 'student')
            <li><a href="{{ url('student_dashboard') }}" class="{{ request()->is('student_dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="{{ url('appointments') }}" class="{{ request()->is('appointments*') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i> Appointments</a></li>
            <li><a href="{{ url('feedback') }}" class="{{ request()->is('feedback*') ? 'active' : '' }}"><i class="bi bi-chat-dots"></i> Feedback</a></li>
        @endif

        {{-- LOGOUT --}}
        <li class="mt-auto">
            <a href="{{ route('logout') }}" class="text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="bi bi-box-arrow-right"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>

    </ul>
</div>


<div class="content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
