@extends('layout')

@section('content')
<style>
    body {
        background-color: #f1f3f4;
        font-family: 'Google Sans', 'Roboto', sans-serif;
    }
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
    .badge {
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 8px;
        font-weight: 600;
    }
</style>

<div class="container py-4">

    {{-- Top Bar --}}
    <div class="gc-topbar">
       
    </div>

    

    {{-- Appointments Table --}}
    <div class="gc-card">
        <h5 class="fw-bold mb-3">All Appointments</h5>
        <div class="table-container">
           <table class="table table-hover align-middle" id="appointmentsTable">
    <thead>
        <tr>
            <th>Student</th>
            <th>Counselor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($appointments as $appointment)
        <tr>
            <td>{{ $appointment->student->name ?? 'N/A' }}</td>
            <td>
                {{-- Counselor dropdown --}}
                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="counselor_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- Assign --</option>
                        @foreach($counselors as $counselor)
                            <option value="{{ $counselor->id }}" {{ $appointment->counselor_id == $counselor->id ? 'selected' : '' }}>
                                {{ $counselor->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="date" value="{{ $appointment->date }}">
                    <input type="hidden" name="time" value="{{ $appointment->time }}">
                    <input type="hidden" name="status" value="{{ $appointment->status }}">
                </form>
            </td>
            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</td>

            {{-- Reason Button + Modal --}}
            <td>
                @if($appointment->reason)
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#reasonModal{{ $appointment->id }}">
                        View
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="reasonModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="reasonModalLabel{{ $appointment->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reasonModalLabel{{ $appointment->id }}">Appointment Reason</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $appointment->reason }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <span class="text-muted">No reason</span>
                @endif
            </td>

            <td>
                <span class="badge bg-{{ $appointment->status === 'Approved' ? 'success' : ($appointment->status === 'Pending' ? 'warning' : 'danger') }}">
                    {{ $appointment->status }}
                </span>
            </td>

            <td>
                {{-- Approve --}}
                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="date" value="{{ $appointment->date }}">
                    <input type="hidden" name="time" value="{{ $appointment->time }}">
                    <input type="hidden" name="counselor_id" value="{{ $appointment->counselor_id }}">
                    <input type="hidden" name="status" value="Approved">
                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-circle"></i></button>
                </form>
                {{-- Reject --}}
                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="date" value="{{ $appointment->date }}">
                    <input type="hidden" name="time" value="{{ $appointment->time }}">
                    <input type="hidden" name="counselor_id" value="{{ $appointment->counselor_id }}">
                    <input type="hidden" name="status" value="Rejected">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


        </div>
    </div>
</div>
@endsection
