@extends('layoutc')

@section('page-title', 'Edit Student Offense')

@section('content')
<div class="container mt-4" style="max-width: 700px;">

   
    <!-- Title -->
    <h3 class="fw-bold mb-4" style="color: #c2185b;">Edit Offense</h3>

    <!-- Card -->
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header fw-semibold" 
             style="font-size: 1.1rem; color: #fff; background: linear-gradient(90deg, #f8bbd0, #f48fb1); border-radius:16px 16px 0 0;">
            Offense Details
        </div>

        <div class="card-body" style="background-color: #fff5f8;">
            <form action="{{ route('counselor.offenses.update', $offense) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Student Selection -->
                <div class="mb-3">
                    <label for="student_id" class="form-label fw-semibold text-muted">Student <span class="text-danger">*</span></label>
                    <select name="student_id" id="student_id" 
                            class="form-select shadow-sm @error('student_id') is-invalid @enderror"
                            style="border-radius: 12px; padding: 12px; border:1px solid #f3c2d8;" required>
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
                    <label for="offense" class="form-label fw-semibold text-muted">Offense <span class="text-danger">*</span></label>
                    <input type="text" name="offense" id="offense" 
                           class="form-control shadow-sm @error('offense') is-invalid @enderror"
                           style="border-radius: 12px; padding: 12px; border:1px solid #f3c2d8;"
                           value="{{ old('offense', $offense->offense) }}" required>
                    @error('offense')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remarks -->
                <div class="mb-3">
                    <label for="remarks" class="form-label fw-semibold text-muted">Remarks</label>
                    <input type="text" name="remarks" id="remarks" 
                           class="form-control shadow-sm @error('remarks') is-invalid @enderror"
                           style="border-radius: 12px; padding: 12px; border:1px solid #f3c2d8;"
                           value="{{ old('remarks', $offense->remarks) }}">
                    @error('remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label for="date" class="form-label fw-semibold text-muted">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" 
                           class="form-control shadow-sm @error('date') is-invalid @enderror"
                           style="border-radius: 12px; padding: 12px; border:1px solid #f3c2d8;"
                           value="{{ old('date', $offense->date) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="btn shadow-sm px-4 py-2 w-100"
                        style="border-radius: 12px; background: linear-gradient(90deg, #f48fb1, #ec407a); border: none; font-weight: 600; color:white;">
                    <i class="bi bi-save"></i> Update Offense
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
