@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📖 Counseling Sessions</h3>
        <a href="{{ url('counselor/session_form') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> New Session
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Student</th>
                        <th>Date</th>
                        <th>Concern</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\CounselingSession::with('student')->latest()->get() as $session)
                        <tr>
                            <td>{{ $session->student->name ?? 'Unknown' }}</td>
                            <td>{{ \Carbon\Carbon::parse($session->date)->format('M d, Y') }}</td>
                            <td>{{ $session->topic }}</td>
                            <td>{{ $session->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No sessions recorded</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
