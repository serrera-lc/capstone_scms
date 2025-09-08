@extends('layout')

@section('content')
<div class="container mt-5">

    <!-- Top Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm p-4 text-center">
                <h5 class="fw-bold text-secondary">Upcoming Appointments</h5>
                <p class="fs-3 fw-bold text-primary">
                    {{ \App\Models\Appointment::where('student_id', auth()->id())->where('date', '>=', now()->toDateString())->count() }}
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-4 text-center">
                <h5 class="fw-bold text-secondary">Last Request Status</h5>
                @php
                    $last = \App\Models\Appointment::where('student_id', auth()->id())->latest()->first();
                @endphp
                <p class="fs-5 fw-semibold text-{{ $last?->status == 'approved' ? 'success' : ($last?->status == 'pending' ? 'warning' : 'danger') }}">
                    {{ $last?->status?->ucfirst() ?? 'No Requests Yet' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Appointment Request Form -->
    <div class="card shadow-sm p-5">
        <h3 class="mb-4 fw-bold">📝 Request Appointment</h3>
        
        <form action="{{ route('student.appointments') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="reason" class="form-label fw-semibold">Reason for Visit <span class="text-danger">*</span></label>
                <textarea 
                    class="form-control @error('reason') is-invalid @enderror" 
                    id="reason" 
                    name="reason" 
                    rows="4"
                    placeholder="Enter the reason for your visit"
                    required>{{ old('reason') }}</textarea>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="date" class="form-label fw-semibold">Preferred Date <span class="text-danger">*</span></label>
                    <input 
                        type="date" 
                        class="form-control @error('date') is-invalid @enderror" 
                        id="date" 
                        name="date" 
                        value="{{ old('date') }}"
                        required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="time" class="form-label fw-semibold">Preferred Time <span class="text-danger">*</span></label>
                    <input 
                        type="time" 
                        class="form-control @error('time') is-invalid @enderror" 
                        id="time" 
                        name="time" 
                        value="{{ old('time') }}"
                        required>
                    @error('time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2">
                <i class="bi bi-send-fill"></i> Submit Request
            </button>
        </form>
    </div>

</div>

<style>
    /* Card styling */
    .card {
        border-radius: 15px;
        background-color: #fff;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .form-label {
        font-size: 1rem;
    }

    button.btn-primary {
        font-weight: 600;
        transition: all 0.2s;
    }

    button.btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Stats panel */
    .card p {
        margin: 0;
    }
</style>
@endsection
