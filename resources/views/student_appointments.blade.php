@extends('clean')

@section('content')
<div class="container mt-4" style="max-width: 950px;">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white rounded-4 shadow-sm border-0">
        <h3 class="fw-bold mb-0" style="color: #1a73e8; font-size: 1.5rem;">
            📅 My Appointments
        </h3>
        <a href="{{ route('student.dashboard') }}" 
           class="btn btn-light shadow-sm rounded-pill px-3 py-2 d-flex align-items-center gap-2"
           style="font-weight: 500; border: 1px solid #e0e0e0;">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>

    {{-- New Appointment Button --}}
    <div class="mb-4 text-end">
        <a href="{{ route('student.appointment_form') }}" 
           class="btn btn-primary rounded-pill shadow-sm px-4 py-2"
           style="background-color: #1a73e8; border-color: #1a73e8; font-weight: 600;">
            <i class="bi bi-calendar-plus"></i> Request New Appointment
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0" 
             role="alert" style="background-color: #e6f4ea; color: #1e4620; font-weight: 500;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Appointments Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-center table-hover" style="border-radius: 12px; overflow: hidden;">
                    <thead style="background-color: #1a73e8; color: white;">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Counselor</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td class="fw-semibold">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</td>
                                <td>{{ $appointment->counselor->name ?? 'TBA' }}</td>
                                <td>
                                    <span class="badge px-3 py-2 shadow-sm"
                                        style="
                                            background-color: 
                                            @if($appointment->status === 'Approved') #34a853;
                                            @elseif($appointment->status === 'Pending') #fbbc05;
                                            @else #9e9e9e;
                                            @endif
                                            ; color: white;
                                            font-size: 0.85rem;
                                            border-radius: 20px;
                                        ">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @if($appointment->status === 'Pending')
                                        <form action="{{ route('appointments.destroy', $appointment) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Cancel this appointment?')" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm rounded-pill shadow-sm"
                                                    style="color: #dc3545; border: 1px solid #dc3545; background-color: white; transition: 0.3s;">
                                                <i class="bi bi-x-circle"></i> Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4" style="font-size: 1rem;">
                                    No appointments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Google Classroom-Inspired Styles --}}
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Roboto', sans-serif;
    }

    .table-hover tbody tr {
        transition: background-color 0.2s ease-in-out;
    }

    .table-hover tbody tr:hover {
        background-color: #f2f7ff !important;
    }

    .card {
        border-radius: 1rem;
        background-color: #fff;
        border: none;
    }

    th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    td {
        font-size: 0.95rem;
    }

    .btn-primary:hover {
        background-color: #155ab6 !important;
        border-color: #155ab6 !important;
        transform: scale(1.03);
        transition: 0.2s;
    }

    .btn-light:hover {
        background-color: #f1f3f4 !important;
        border-color: #e0e0e0;
    }

    .shadow-sm {
        transition: all 0.25s ease-in-out;
    }

    .shadow-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12) !important;
    }
</style>
@endsection
