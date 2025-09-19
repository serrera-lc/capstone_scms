@extends('layout')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-4">📊 Reports & Analytics</h2>

    <!-- Dashboard Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Appointments</h5>
                    <h3 class="fw-bold">{{ $totalAppointments ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Sessions</h5>
                    <h3 class="fw-bold">{{ $totalSessions ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Offenses</h5>
                    <h3 class="fw-bold">{{ $totalOffenses ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Users</h5>
                    <h3 class="fw-bold">{{ $totalUsers ?? 0 }}</h3>
                    <small class="text-muted">{{ $activeUsers ?? 0 }} active this month</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Engagement -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>📈 Student Engagement (Last 30 Days)</h5>
            <p>Appointments: <strong>{{ $studentEngagement['appointments'] ?? 0 }}</strong></p>
            <p>Sessions: <strong>{{ $studentEngagement['sessions'] ?? 0 }}</strong></p>
        </div>
    </div>

    <!-- Counselor Performance -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>👩‍🏫 Counselor Performance</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Counselor</th>
                        <th>Sessions Handled</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($counselorPerformance ?? [] as $counselor)
                        <tr>
                            <td>{{ $counselor->name }}</td>
                            <td>{{ $counselor->counseling_sessions_count ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No counselor data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Misconduct Reports -->
    <div class="card">
        <div class="card-body">
            <h5>🚨 Misconduct Reports</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Offense</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Reported At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports ?? [] as $report)
                        <tr>
                            <td>{{ $report->student->name ?? 'Unknown' }}</td>
                            <td>{{ $report->offense }}</td>
                            <td>{{ $report->remarks ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $report->status === 'resolved' ? 'success' : ($report->status === 'reviewed' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                            <td>
                                <!-- Edit button -->
                                <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-primary">Edit</button>
                                </form>

                                <!-- Delete button -->
                                <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No reports found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
