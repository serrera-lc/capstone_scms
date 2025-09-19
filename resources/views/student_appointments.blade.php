@extends('layouts')

@section('content')
<div class="container mt-4" style="max-width: 950px;">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white rounded-4 shadow-sm border-0">
        <h3 class="fw-bold mb-0" style="color: #d63384; font-size: 1.5rem;">
            My Appointments
        </h3>
        <a href="{{ route('student.dashboard') }}" 
           class="btn btn-light shadow-sm rounded-pill px-3 py-2 d-flex align-items-center gap-2"
           style="font-weight: 500; border: 1px solid #f8bbd0; color: #d63384;">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>

    {{-- New Appointment Button --}}
    <div class="mb-4 text-end">
        <a href="{{ route('student.appointment_form') }}" 
           class="btn btn-pink rounded-pill shadow-sm px-4 py-2"
           style="background-color: #d63384; border-color: #d63384; font-weight: 600; color: white;">
            <i class="bi bi-calendar-plus"></i> Request New Appointment
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0" 
             role="alert" style="background-color: #fde6ec; color: #880e4f; font-weight: 500;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Appointments Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-center table-hover" style="border-radius: 12px; overflow: hidden;">
                    <thead style="background-color: #f8bbd0; color: white;">
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
                                            @elseif($appointment->status === 'Pending') #f8bbd0;
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
                                                    style="color: #d63384; border: 1px solid #d63384; background-color: white; transition: 0.3s;">
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

{{-- Light Pink + White Styles --}}
<style>
    body {
        background-color: #fff0f6;
        font-family: 'Roboto', sans-serif;
    }

    .table-hover tbody tr {
        transition: background-color 0.2s ease-in-out;
    }

    .table-hover tbody tr:hover {
        background-color: #fde6ec !important;
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

    .btn-pink:hover {
        background-color: #b71c4a !important;
        border-color: #b71c4a !important;
        transform: scale(1.03);
        transition: 0.2s;
        color: white;
    }

    .btn-light:hover {
        background-color: #fff0f6 !important;
        border-color: #f8bbd0;
        color: #d63384;
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
