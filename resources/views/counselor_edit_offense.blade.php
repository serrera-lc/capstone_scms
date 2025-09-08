@extends('clean')

@section('page-title', 'Edit Student Offense')

@section('content')
<div class="container mt-4" style="max-width: 700px;">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('counselor.offenses') }}" class="btn btn-light shadow-sm d-flex align-items-center gap-2" style="border-radius: 8px;">
            <i class="bi bi-arrow-left-circle"></i> Back to Offenses List
        </a>
    </div>

    <!-- Title -->
    <h3 class="fw-bold mb-4" style="color: #3c4043;">✏️ Edit Offense</h3>

    <!-- Card -->
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white border-0 fw-semibold" style="font-size: 1.1rem; color: #202124;">
            Offense Details
        </div>

        <div class="card-body">
            <form action="{{ route('counselor.offenses.update', $offense) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Student Selection -->
                <div class="mb-3">
                    <label for="student_id" class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                    <select name="student_id" id="student_id" 
                            class="form-select shadow-sm @error('student_id') is-invalid @enderror"
                            style="border-radius: 10px; padding: 10px;" required>
                        <option value="">Select a student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $offense->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Offense -->
                <div class="mb-3">
                    <label for="offense" class="form-label fw-semibold">Offense <span class="text-danger">*</span></label>
                    <input type="text" name="offense" id="offense" 
                           class="form-control shadow-sm @error('offense') is-invalid @enderror"
                           style="border-radius: 10px; padding: 10px;"
                           value="{{ old('offense', $offense->offense) }}" required>
                    @error('offense')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remarks -->
                <div class="mb-3">
                    <label for="remarks" class="form-label fw-semibold">Remarks</label>
                    <input type="text" name="remarks" id="remarks" 
                           class="form-control shadow-sm @error('remarks') is-invalid @enderror"
                           style="border-radius: 10px; padding: 10px;"
                           value="{{ old('remarks', $offense->remarks) }}">
                    @error('remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label for="date" class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" 
                           class="form-control shadow-sm @error('date') is-invalid @enderror"
                           style="border-radius: 10px; padding: 10px;"
                           value="{{ old('date', $offense->date) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="btn btn-primary shadow-sm px-4 py-2"
                        style="border-radius: 10px; background-color: #1a73e8; border: none; font-weight: 600;">
                    <i class="bi bi-save"></i> Update Offense
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
