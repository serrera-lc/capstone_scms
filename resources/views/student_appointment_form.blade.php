@extends('clean')

@section('content')
<div class="container mt-4" style="max-width: 700px;">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white rounded-4 shadow-sm border-0">
        <h3 class="fw-bold mb-0" style="color:#1a73e8; font-size:1.4rem;">
            <i class="bi bi-calendar-event"></i> Request Appointment
        </h3>
        <a href="{{ route('student.dashboard') }}" 
           class="btn btn-light border shadow-sm rounded-pill px-3 py-2 d-flex align-items-center gap-2 hover-effect"
           style="font-weight: 500;">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
    </div>

    {{-- Appointment Form Card --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white google-card">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            {{-- Select Counselor --}}
            <div class="mb-3">
                <label for="counselor_id" class="form-label fw-semibold" style="color:#202124;">
                    <i class="bi bi-person-badge"></i> Choose Counselor <span class="text-danger">*</span>
                </label>
                <select id="counselor_id" name="counselor_id" 
                        class="form-select rounded-3 shadow-sm @error('counselor_id') is-invalid @enderror" 
                        required>
                    <option value="">-- Select a Counselor --</option>
                    @foreach($counselors as $counselor)
                        <option value="{{ $counselor->id }}" {{ old('counselor_id') == $counselor->id ? 'selected' : '' }}>
                            {{ $counselor->name }}
                        </option>
                    @endforeach
                </select>
                @error('counselor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Date --}}
            <div class="mb-3">
                <label for="date" class="form-label fw-semibold" style="color:#202124;">
                    <i class="bi bi-calendar-date"></i> Date <span class="text-danger">*</span>
                </label>
                <input type="date" id="date" name="date" 
                       class="form-control rounded-3 shadow-sm @error('date') is-invalid @enderror" 
                       value="{{ old('date') }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Time --}}
            <div class="mb-3">
                <label for="time" class="form-label fw-semibold" style="color:#202124;">
                    <i class="bi bi-clock"></i> Time <span class="text-danger">*</span>
                </label>
                <input type="time" id="time" name="time" 
                       class="form-control rounded-3 shadow-sm @error('time') is-invalid @enderror" 
                       value="{{ old('time') }}" required>
                @error('time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Reason --}}
            <div class="mb-3">
                <label for="reason" class="form-label fw-semibold" style="color:#202124;">
                    <i class="bi bi-pencil-square"></i> Reason <span class="text-danger">*</span>
                </label>
                <textarea id="reason" name="reason" rows="3" 
                          class="form-control rounded-3 shadow-sm @error('reason') is-invalid @enderror" 
                          placeholder="Briefly explain the reason for your appointment..." 
                          required>{{ old('reason') }}</textarea>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="text-end">
                <button type="submit" 
                        class="btn btn-primary px-4 py-2 rounded-pill shadow-sm hover-effect"
                        style="background-color:#1a73e8; border-color:#1a73e8; font-weight:600;">
                    <i class="bi bi-send-check"></i> Submit Appointment
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Google Classroom-Inspired Styles --}}
<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Roboto', sans-serif;
    }

    .google-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease-in-out;
    }

    .google-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 22px rgba(0,0,0,0.15);
    }

    .hover-effect {
        transition: all 0.3s ease-in-out;
    }

    .hover-effect:hover {
        background-color: #F1F3F4 !important;
        transform: translateY(-2px);
    }

    .form-control, .form-select {
        border: 1px solid #e0e0e0;
        padding: 10px 12px;
        font-size: 0.95rem;
        transition: all 0.2s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
    }

    textarea {
        resize: none;
    }
</style>
@endsection
