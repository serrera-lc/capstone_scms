@extends('clean')

@section('content')
<style>
    /* === Google Classroom Inspired Design === */
    body {
        background-color: #f1f3f4;
        font-family: 'Google Sans', 'Roboto', sans-serif;
    }

    /* Top Bar (Title + Back Button) */
    .gc-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .gc-topbar h2 {
        font-weight: bold;
        color: #202124;
        margin: 0;
    }

    .gc-btn {
        border-radius: 8px;
        font-weight: 500;
        background: #1a73e8;
        color: #fff;
        padding: 6px 14px;
        transition: 0.2s;
        border: 1px solid transparent;
    }

    .gc-btn:hover {
        background: #1558c0;
    }

    /* Stats Card */
    .stats-card {
        border-radius: 12px;
        text-align: center;
        padding: 18px;
        color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: 0.2s;
    }

    .stats-card h3 {
        margin: 5px 0 0;
        font-weight: bold;
        font-size: 26px;
    }

    .stats-card i {
        font-size: 2rem;
        margin-bottom: 8px;
    }

    /* Main Card */
    .gc-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(60, 64, 67, 0.15);
        padding: 20px;
        transition: all 0.2s ease-in-out;
    }

    .gc-card:hover {
        box-shadow: 0 4px 12px rgba(60, 64, 67, 0.2);
    }

    /* Table */
    .table-container {
        border-radius: 12px;
        overflow: hidden;
        margin-top: 15px;
    }

    .table {
        border-radius: 12px;
        background: #fff;
        margin-bottom: 0;
    }

    .table thead {
        background-color: #f8f9fa;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: background 0.15s;
    }

    .table tbody tr:hover {
        background-color: #f1f3f4;
    }

    /* Badge Styling */
    .badge {
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 8px;
        font-weight: 600;
    }
</style>

<div class="container py-4">

    {{-- Top Bar with Title & Back Button --}}
    <div class="gc-topbar">
        <h2>📅 Appointments Management</h2>
       <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary rounded-pill shadow-sm px-4">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: #1a73e8;">
                <i class="bi bi-people-fill"></i>
                <h6>Total Appointments</h6>
                <h3>{{ $appointments->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: #fbbc05;">
                <i class="bi bi-hourglass-split"></i>
                <h6>Pending</h6>
                <h3>{{ $appointments->where('status','Pending')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: #34a853;">
                <i class="bi bi-check-circle"></i>
                <h6>Approved</h6>
                <h3>{{ $appointments->where('status','Approved')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: #ea4335;">
                <i class="bi bi-x-circle"></i>
                <h6>Rejected</h6>
                <h3>{{ $appointments->where('status','Rejected')->count() }}</h3>
            </div>
        </div>
    </div>

    {{-- Appointments Table --}}
    <div class="gc-card">
        <h5 class="fw-bold mb-3">📋 All Appointments</h5>
        <div class="table-container">
            <table class="table table-hover align-middle" id="appointmentsTable">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Counselor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->student->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->counselor->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</td>
                        <td>
                            <span class="badge bg-{{ $appointment->status === 'Approved' ? 'success' : ($appointment->status === 'Pending' ? 'warning' : 'danger') }}">
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
@endsection
