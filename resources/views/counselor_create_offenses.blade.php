@extends('layoutc')

@section('page-title', 'Add Student Offense')

@section('content')
<style>
    /* ===== Google Classroom Inspired Form Design ===== */
    body {
        background-color: #f8f9fb;
        font-family: 'Roboto', sans-serif;
    }

    /* Header Section */
    .page-header {
        background: #fff;
        padding: 18px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h3 {
        font-weight: 700;
        font-size: 1.4rem;
        color: #202124;
        margin: 0;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: #fff;
        font-weight: 600;
        font-size: 1.1rem;
        color: #3c4043;
        border-bottom: 1px solid #eee;
    }

    /* Input & Select Styling */
    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px 14px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4285f4;
        box-shadow: 0 0 6px rgba(66, 133, 244, 0.3);
    }

    /* Buttons */
    .btn-custom {
        border-radius: 50px;
        padding: 8px 18px;
        font-weight: 500;
        transition: all 0.3s ease-in-out;
    }

    .btn-custom:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }

    .btn-secondary {
        border-radius: 50px;
    }
</style>

<div class="container my-4">

    <!-- Header Section -->
    <div class="page-header mb-4">
         <h2 class="fw-bold" style="color: #d63384;">
            <i class="bi bi-journal-text"></i> Counseling Sessions
        </h2>
        <h3>📝 Add New Student Offense</h3>
        <span></span> <!-- For balanced spacing -->
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card shadow-sm">
        <div class="card-header">Offense Details</div>
        <div class="card-body">
            <form action="{{ route('counselor.offenses.store') }}" method="POST">
                @csrf

                <!-- Student -->
                <div class="mb-3">
                    <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                    <select name="student_id" id="student_id"
                        class="form-select @error('student_id') is-invalid @enderror" required>
                        <option value="">Select a student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
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
                    <label for="offense" class="form-label">Offense <span class="text-danger">*</span></label>
                    <input type="text" name="offense" id="offense"
                        class="form-control @error('offense') is-invalid @enderror"
                        value="{{ old('offense') }}" placeholder="Enter offense title" required>
                    @error('offense')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remarks -->
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <input type="text" name="remarks" id="remarks"
                        class="form-control @error('remarks') is-invalid @enderror"
                        value="{{ old('remarks') }}" placeholder="Enter additional notes (optional)">
                    @error('remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date"
                        class="form-control @error('date') is-invalid @enderror"
                        value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success btn-custom shadow-sm">
                    <i class="bi bi-plus-circle"></i> Add Offense
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
