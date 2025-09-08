@extends('layout')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4"><i class="bi bi-pencil-square"></i> Record Counseling Session</h3>

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('counselor.sessions.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <!-- Student Selection -->
        <div class="mb-3">
            <label for="student_id" class="form-label fw-bold">Student <span class="text-danger">*</span></label>
            <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                <option value="">-- Select Student --</option>
                @foreach(\App\Models\User::where('role', 'student')->orderBy('name')->get() as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            @error('student_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Topic / Concern -->
        <div class="mb-3">
            <label for="topic" class="form-label fw-bold">Concern / Topic <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('topic') is-invalid @enderror" id="topic" name="topic"
                   value="{{ old('topic') }}" placeholder="Enter the main concern" required>
            @error('topic')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Notes / Intervention -->
        <div class="mb-3">
            <label for="notes" class="form-label fw-bold">Intervention / Notes</label>
            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                      placeholder="Write any notes or interventions">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Date and Time -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="date" class="form-label fw-bold">Session Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                       value="{{ old('date', now()->toDateString()) }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="time" class="form-label fw-bold">Session Time <span class="text-danger">*</span></label>
                <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time"
                       value="{{ old('time', now()->format('H:i')) }}" required>
                @error('time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Save Session
        </button>
    </form>
</div>

<!-- Bootstrap validation script -->
<script>
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection
