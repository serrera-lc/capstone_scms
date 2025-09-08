@extends('clean')

@section('content')
<div class="container mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white rounded-3 shadow-sm header-card">
        <h3 class="fw-bold mb-0" style="color: #1a73e8;">
            <i class="bi bi-chat-left-text"></i> Student Feedback
        </h3>
        <a href="{{ route('student.dashboard') }}" 
           class="btn btn-light border shadow-sm rounded-pill px-3 py-2 google-btn">
            <i class="bi bi-arrow-left-circle"></i> Dashboard
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Feedback Form --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4 google-card">
        <div class="card-body p-4">
            <form action="{{ route('student.feedback.store') }}" method="POST">
                @csrf

                {{-- Select Counselor --}}
                <div class="mb-3">
                    <label for="counselor_id" class="form-label fw-semibold text-muted">
                        Counselor <span class="text-danger">*</span>
                    </label>
                    <select id="counselor_id" name="counselor_id" 
                        class="form-select rounded-3 shadow-sm @error('counselor_id') is-invalid @enderror" required>
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

                {{-- Feedback --}}
                <div class="mb-3">
                    <label for="feedback" class="form-label fw-semibold text-muted">
                        Your Feedback <span class="text-danger">*</span>
                    </label>
                    <textarea id="feedback" name="feedback" rows="4" 
                        class="form-control rounded-3 shadow-sm @error('feedback') is-invalid @enderror" 
                        placeholder="Write your feedback here..." required>{{ old('feedback') }}</textarea>
                    @error('feedback')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Rating --}}
                <div class="mb-3">
                    <label for="rating" class="form-label fw-semibold text-muted">
                        Rate the Counselor <span class="text-danger">*</span>
                    </label>
                    <select id="rating" name="rating" 
                        class="form-select rounded-3 shadow-sm @error('rating') is-invalid @enderror" required>
                        <option value="">-- Select Rating --</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary rounded-pill shadow-sm px-4 google-primary-btn">
                        <i class="bi bi-send-fill"></i> Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Previous Feedback --}}
    <div class="card shadow-sm border-0 rounded-4 google-card">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3" style="color: #1a73e8;">
                📝 Previous Feedback
            </h5>

            @if($feedbacks->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($feedbacks as $feedback)
                        <li class="list-group-item d-flex justify-content-between align-items-start bg-light rounded-3 shadow-sm mb-2 p-3 google-feedback-item">
                            <div>
                                <strong class="fw-semibold" style="color: #202124;">
                                    {{ $feedback->counselor->name ?? 'Counselor' }}
                                </strong>
                                <div class="text-warning mt-1" style="font-size: 1.1rem;">
                                    @for ($i = 0; $i < $feedback->rating; $i++)
                                        ★
                                    @endfor
                                    @for ($i = $feedback->rating; $i < 5; $i++)
                                        ☆
                                    @endfor
                                </div>
                                <p class="mb-1 text-muted fst-italic">"{{ $feedback->feedback }}"</p>
                            </div>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($feedback->created_at)->format('M d, Y') }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0">No feedback submitted yet.</p>
            @endif
        </div>
    </div>
</div>

{{-- Google Classroom-Inspired Styling --}}
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Roboto', sans-serif;
        color: #202124;
    }

    /* Header Card */
    .header-card {
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }

    /* Google Card */
    .google-card {
        background-color: #fff;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    .google-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Form Inputs */
    .form-select, .form-control {
        border: 1px solid #dadce0;
        padding: 10px;
        transition: all 0.2s ease;
        background-color: #fff;
    }

    .form-select:focus, .form-control:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.25);
    }

    /* Primary Button */
    .google-primary-btn {
        background-color: #1a73e8 !important;
        border-color: #1a73e8 !important;
        font-weight: 500;
        transition: all 0.2s;
    }

    .google-primary-btn:hover {
        background-color: #1558c0 !important;
        border-color: #1558c0 !important;
        transform: scale(1.03);
    }

    /* Secondary Button */
    .google-btn:hover {
        background-color: #f1f3f4 !important;
    }

    /* Previous Feedback Styling */
    .google-feedback-item {
        transition: all 0.2s ease-in-out;
    }

    .google-feedback-item:hover {
        background-color: #fefefe;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    textarea {
        resize: none;
    }
</style>
@endsection
