@extends('layouts')

@section('content')
<div class="container mt-4" style="max-width: 700px;">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-4 shadow-sm" style="background-color:#ffe6f0;">
        <h3 class="fw-bold mb-0" style="color:#d63384; font-size:1.4rem;">
            <i class="bi bi-calendar-event"></i> Request Appointment
        </h3>
        
    </div>

    {{-- Appointment Form Card --}}
    <div class="card shadow-sm rounded-4 p-4" style="background-color:white;">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            {{-- Select Counselor with Images --}}
            <div class="mb-3">
                <label class="form-label fw-semibold" style="color:#202124;">
                    <i class="bi bi-person-badge"></i> Choose Counselor <span class="text-danger">*</span>
                </label>
                <input type="hidden" name="counselor_id" id="counselor_id" value="{{ old('counselor_id') }}">
                <div class="dropdown">
                    <button class="btn btn-light border rounded-3 w-100 text-start" type="button" id="dropdownCounselors" data-bs-toggle="dropdown" aria-expanded="false">
                        Select a Counselor
                    </button>
                    <ul class="dropdown-menu w-100 p-2" aria-labelledby="dropdownCounselors" style="max-height: 250px; overflow-y: auto;">
                        @foreach($counselors as $counselor)
                        <li class="d-flex align-items-center mb-2 counselor-option" style="cursor:pointer;" data-id="{{ $counselor->id }}">
                            <img src="{{ $counselor->profile_image_url ?? 'https://via.placeholder.com/40' }}" 
                                 alt="Profile" class="rounded-circle me-2" width="40" height="40">
                            <span>{{ $counselor->name }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @error('counselor_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
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
                        class="btn rounded-pill shadow-sm"
                        style="background-color:#d63384; color:white; font-weight:600;">
                    <i class="bi bi-send-check"></i> Submit Appointment
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    body {
        background-color: #fff0f6;
        font-family: 'Roboto', sans-serif;
    }

    .card {
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 22px rgba(0,0,0,0.15);
    }

    .form-control, .form-select, textarea {
        border: 1px solid #e0e0e0;
        padding: 10px 12px;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #d63384;
        box-shadow: 0 0 0 3px rgba(214,51,132,0.2);
    }

    textarea {
        resize: none;
    }

    .hover-effect {
        transition: all 0.3s ease-in-out;
    }

    .hover-effect:hover {
        transform: translateY(-2px);
    }

    .counselor-option:hover {
        background-color: #ffe6f0;
        border-radius: 6px;
        padding-left: 4px;
    }
</style>

{{-- Custom JS for Dropdown Selection --}}
<script>
    document.querySelectorAll('.counselor-option').forEach(option => {
        option.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.querySelector('span').textContent;
            document.getElementById('counselor_id').value = id;
            document.getElementById('dropdownCounselors').textContent = name;
        });
    });
</script>
@endsection
