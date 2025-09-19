<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('page-title', 'Student Dashboard') - SCMS</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: #fdfdfd;
        margin: 0;
    }

    /* Top Navbar */
    .top-navbar {
        background: #f8bbd0;
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
        top: 70px;
        left: 0;
        border-right: 1px solid #f8bbd0;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        z-index: 1001;
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
        margin-bottom: 10px;
        transition: 0.3s;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #f8bbd0;
        color: #880e4f;
        font-weight: 600;
    }
    .sidebar.collapsed { width: 70px; }
    .sidebar.collapsed .nav-link span { display: none; }

    /* Mobile Sidebar */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.active {
            transform: translateX(0);
        }
    }

    /* Main Content */
    .content {
        margin-left: 240px;
        padding: 100px 25px 40px;
        transition: margin-left 0.3s ease;
    }
    .content.expanded { margin-left: 70px; }
    @media (max-width: 768px) { .content { margin-left: 0 !important; padding: 100px 15px; } }

    /* Cards */
    .card { border-radius: 16px; border: none; }
    .card-header { background: #fff; border-bottom: 1px solid #f8bbd0; font-weight: 600; color: #d63384; }

    /* Sidebar overlay for mobile */
    #sidebarOverlay {
        display: none;
        position: fixed;
        top: 70px; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.3);
        z-index: 1000;
    }
    #sidebarOverlay.active { display: block; }
</style>
</head>
<body>

<!-- Top Navbar -->
<div class="top-navbar">
    <button class="btn btn-light border rounded-circle me-3" id="sidebarToggle">
        <i class="bi bi-list fs-4"></i>
    </button>
    <h4>@yield('page-title', 'Student Dashboard')</h4>
    <button type="button" class="btn btn-light border rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
        👋 Welcome, {{ auth()->user()->name }}
    </button>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Replace SCMS text with logo -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/lcguidancelogo.jpg') }}" alt="SCMS Logo" class="img-fluid" style="max-height: 60px;">
    </div>

    <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
    </a>
    <a href="{{ route('student.appointments') }}" class="nav-link {{ request()->routeIs('student.appointments') ? 'active' : '' }}">
        <i class="bi bi-calendar-check"></i> <span>Appointments</span>
    </a>
    <a href="{{ route('student.feedback') }}" class="nav-link {{ request()->routeIs('student.feedback') ? 'active' : '' }}">
        <i class="bi bi-chat-dots"></i> <span>Feedback</span>
    </a>
    <a href="{{ route('student.profile') }}" class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
        <i class="bi bi-person"></i> <span>Profile</span>
    </a>
</div>


<!-- Sidebar overlay for mobile -->
<div id="sidebarOverlay"></div>

<!-- Main Content -->
<div class="content" id="content">
    @yield('content')
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


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const sidebar = document.getElementById("sidebar");
const content = document.getElementById("content");
const overlay = document.getElementById("sidebarOverlay");
const toggleBtn = document.getElementById("sidebarToggle");

toggleBtn.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");
    } else {
        sidebar.classList.toggle("collapsed");
        content.classList.toggle("expanded");
    }
});

// Close sidebar on clicking overlay (mobile)
overlay.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
});
</script>

</body>
</html>
