@extends('layoutc')

@section('content')
<div class="container mt-5" style="max-width: 1200px;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold" style="color: #d63384;">
            <i class="bi bi-calendar-check me-2"></i> Student Appointments
        </h3>
        <span class="badge rounded-pill shadow-sm px-3 py-2"
              style="background-color: #f8bbd0; color:#3c4043; font-size: 14px;">
            Total: {{ $appointments->count() }}
        </span>
    </div>

    <!-- No Appointments Message -->
    @if($appointments->isEmpty())
        <div class="alert alert-info text-center shadow-sm rounded-3" style="font-size: 15px;">
            <i class="bi bi-info-circle-fill me-1"></i> No student appointments assigned yet.
        </div>
    @else
        <!-- Appointment List Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header rounded-top-4 d-flex align-items-center"
                 style="background-color: #f8bbd0; color: #880e4f; font-weight: 600; font-size: 16px;">
                <i class="bi bi-list-check me-2"></i> Appointment List
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center" style="font-size: 14px;">
                        <thead style="background-color: #fce4ec; color: #4a0e28; font-weight: 600;">
                            <tr>
                                <th>Student</th>
                                <th>Reason</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                @php
                                    $date = \Carbon\Carbon::parse($appointment->date);
                                    $time = \Carbon\Carbon::parse($appointment->time);
                                    $isPast = $date->isPast();
                                @endphp
                                <tr class="align-middle">
                                    <!-- Student Name -->
                                    <td class="fw-semibold">
                                        <i class="bi bi-person-circle me-1 text-pink"></i>
                                        {{ $appointment->student->name ?? 'N/A' }}
                                    </td>

                                    <!-- Reason for Appointment -->
                                    <td>
                                        {{ $appointment->reason ?? '-' }}
                                    </td>

                                    <!-- Appointment Date -->
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 shadow-sm 
                                                     {{ $isPast ? 'bg-light text-muted border' : 'bg-light text-dark' }}"
                                              style="font-size: 12px;">
                                            {{ $date->format('F d, Y') }}
                                        </span>
                                    </td>

                                    <!-- Appointment Time -->
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 shadow-sm 
                                                     {{ $isPast ? 'bg-secondary text-light' : 'bg-light text-dark border' }}"
                                              style="font-size: 12px;">
                                            {{ $time->format('g:i A') }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if($isPast)
                                            <span class="badge rounded-pill px-3 py-2 shadow-sm" 
                                                  style="background-color:#ad1457; color:#fff;">
                                                Done
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-3 py-2 shadow-sm"
                                                  style="
                                                      background-color:
                                                      {{ $appointment->status === 'Approved' ? '#d63384' : 
                                                         ($appointment->status === 'Pending' ? '#f8bbd0' : '#ea4335') }};
                                                      color: {{ $appointment->status === 'Pending' ? '#3c4043' : '#fff' }};
                                                      font-size: 12px;">
                                                {{ $appointment->status }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action Dropdown -->
                                    <td class="text-end">
                                        @if(!$isPast)
                                            <form action="{{ route('appointments.updateStatus', $appointment) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" onchange="this.form.submit()" 
                                                        class="form-select form-select-sm shadow-sm rounded-pill"
                                                        style="min-width: 130px;">
                                                    <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Approved" {{ $appointment->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="Rejected" {{ $appointment->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </form>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Extra Styling -->
<style>
    /* Table Header */
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    /* Hover Effects */
    .table-hover tbody tr:hover {
        background-color: #fff0f5;
        transition: 0.2s;
    }

    /* Badge Style */
    .badge {
        font-size: 0.85rem;
        border-radius: 20px;
    }

    /* Dropdowns */
    .form-select-sm {
        width: auto;
        display: inline-block;
    }

    /* Card Header Style */
    .card-header {
        font-size: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    /* Shadow Hover Effect */
    .hover-shadow:hover {
        box-shadow: 0 4px 10px rgba(214, 51, 132, 0.3);
        transition: 0.3s ease-in-out;
    }

    /* Pink Icon */
    .text-pink {
        color: #d63384 !important;
    }
</style>
@endsection
