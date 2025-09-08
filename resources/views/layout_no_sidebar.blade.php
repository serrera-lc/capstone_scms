{{-- resources/views/counselor_dashboard.blade.php --}}
@extends('layout')

@section('page-title', 'Counselor Dashboard')

@section('content')
<div class="container mt-4">
    <h2>Welcome, {{ auth()->user()->name }}</h2>

    <!-- Dashboard stats (example) -->
    <div class="row my-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary p-3">
                <h5>Total Appointments</h5>
                <div class="h2">{{ $totalAppointments ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success p-3">
                <h5>Pending Sessions</h5>
                <div class="h2">{{ $pendingSessions ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning p-3">
                <h5>Completed Sessions</h5>
                <div class="h2">{{ $completedSessions ?? 0 }}</div>
            </div>
        </div>
    </div>

<!-- Sessions Table -->
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="sessionsTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Counselor</th>
                <th>Concern</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($sessions) && $sessions->count() > 0)
                @foreach($sessions as $index => $session)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $session->student?->name ?? 'No Student' }}</td>
                        <td>{{ $session->counselor?->name ?? 'No Counselor' }}</td>
                        <td>{{ $session->concern }}</td>
                        <td>{{ $session->date }}</td>
                        <td>{{ $session->status ?? 'Pending' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No sessions available</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


@push('scripts')
<script>
    $(document).ready(function () {
        $('#sessionsTable').DataTable();
    });
</script>
@endpush
@endsection
