@extends('layout')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📜 System Logs</h3>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Example log --}}
                    <tr>
                        <td>Admin</td>
                        <td>Logged in</td>
                        <td>Sept 4, 10:00 AM</td>
                    </tr>

                    {{-- You can loop through logs dynamically --}}
                    {{-- @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
