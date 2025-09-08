@extends('clean')

@section('page-title', 'Counseling Sessions')

@section('content')
<div class="container my-5" style="max-width: 1200px;">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('counselor.dashboard') }}" 
           class="btn btn-light border rounded-pill shadow-sm px-4 py-2 hover-shadow"
           style="font-weight: 500;">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #3c4043;">
            <i class="bi bi-journal-text"></i> Counseling Sessions
        </h2>
        <span class="badge rounded-pill shadow-sm px-3 py-2"
              style="background-color: #1a73e8; font-size: 14px;">
            Total Sessions: {{ $sessions->count() ?? 0 }}
        </span>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3 d-flex align-items-center" style="font-size: 15px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Add Session Form -->
    <div class="card border-0 shadow-sm rounded-4 mb-5" style="background-color: #fff;">
        <div class="card-header rounded-top-4" 
             style="background-color: #1a73e8; color: #fff; font-weight: 600; font-size: 16px;">
            <i class="bi bi-plus-circle"></i> Add Counseling Session
        </div>
        <div class="card-body">
            <form action="{{ route('counselor.sessions.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Student Dropdown -->
                    <div class="col-md-4">
                        <label for="student_id" class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3 shadow-sm @error('student_id') is-invalid @enderror" 
                                id="student_id" name="student_id" required>
                            <option value="">Select a student</option>
                            @foreach($students ?? [] as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Concern Input -->
                    <div class="col-md-4">
                        <label for="concern" class="form-label fw-semibold">Concern <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control rounded-3 shadow-sm @error('concern') is-invalid @enderror"
                               id="concern" name="concern"
                               value="{{ old('concern') }}" placeholder="Enter session concern" required>
                        @error('concern') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Date Input -->
                    <div class="col-md-2">
                        <label for="date" class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control rounded-3 shadow-sm @error('date') is-invalid @enderror"
                               id="date" name="date"
                               value="{{ old('date', date('Y-m-d')) }}" required>
                        @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-2 d-grid align-items-end">
                        <button type="submit" 
                                class="btn rounded-pill shadow-sm"
                                style="background-color: #34a853; color: #fff; font-weight: 600;">
                            <i class="bi bi-save"></i> Save
                        </button>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-3">
                    <label for="notes" class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" id="notes"
                              class="form-control rounded-3 shadow-sm @error('notes') is-invalid @enderror"
                              rows="2" placeholder="Optional notes">{{ old('notes') }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </form>
        </div>
    </div>

    <!-- Sessions Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header rounded-top-4" 
             style="background-color: #f1f3f4; font-weight: 600; color: #3c4043;">
            <i class="bi bi-list-check"></i> Recorded Sessions
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle" style="font-size: 14px;">
                    <thead style="background-color: #e8f0fe; color: #3c4043;">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Concern</th>
                            <th>Notes</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions ?? [] as $session)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><i class="bi bi-person-circle"></i> {{ $session->student?->name ?? 'N/A' }}</td>
                                <td>{{ $session->concern ?? '-' }}</td>
                                <td>{{ $session->notes ?? '-' }}</td>
                                <td>
                                    <span class="badge rounded-pill shadow-sm" 
                                          style="background-color: #1a73e8; color: #fff; font-size: 12px;">
                                        {{ $session->date ? \Carbon\Carbon::parse($session->date)->format('M d, Y') : '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    <i class="bi bi-emoji-frown"></i> No counseling sessions recorded.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
