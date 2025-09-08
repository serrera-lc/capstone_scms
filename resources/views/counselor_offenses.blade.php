@extends('clean')

@section('page-title', 'Student Offenses')

@section('content')
<style>
    /* ===== Google Classroom Inspired Design ===== */
    body {
        background-color: #f8f9fb;
        font-family: 'Roboto', sans-serif;
    }

    /* Header */
    .header-container {
        background: #fff;
        padding: 20px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-container h2 {
        font-weight: 700;
        font-size: 1.6rem;
        color: #202124;
        margin: 0;
    }

    /* Search Bar */
    .search-box {
        position: relative;
        margin-top: 15px;
    }

    .search-box input {
        padding: 10px 15px 10px 40px;
        border-radius: 50px;
        border: 1px solid #ddd;
        width: 100%;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
    }

    .search-box input:focus {
        border-color: #4285f4;
        box-shadow: 0 2px 8px rgba(66, 133, 244, 0.2);
        outline: none;
    }

    .search-box i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #888;
    }

    /* Cards */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        background-color: #fff;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
    }

    .card-title {
        font-weight: 600;
        color: #202124;
    }

    /* Buttons */
    .btn-custom {
        border-radius: 50px;
        padding: 8px 18px;
        font-weight: 500;
        transition: 0.3s ease-in-out;
    }

    .btn-custom:hover {
        opacity: 0.9;
        transform: scale(1.03);
    }

    .btn-outline-primary {
        border-radius: 50px;
    }

    /* Empty State */
    .empty-state {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        font-size: 1.1rem;
    }
</style>

<div class="container my-5">

    <!-- Header + Buttons -->
    <div class="header-container mb-4">
        <a href="{{ url('/counselor/dashboard') }}" class="btn btn-outline-primary btn-custom shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
        <h2>📋 Student Offenses</h2>
        <a href="{{ route('counselor.offenses.create') }}" class="btn btn-primary btn-custom shadow-sm">
            <i class="bi bi-plus-circle"></i> Add Offense
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search Bar --}}
    <div class="search-box mb-4">
        <i class="bi bi-search"></i>
        <input type="text" id="searchOffense" placeholder="Search by student or offense...">
    </div>

    {{-- Offenses Cards --}}
    <div class="row g-4">
        @forelse($offenses as $offense)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 p-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $offense->student->name ?? 'N/A' }}</h5>
                        <p class="card-text mb-1">
                            <span class="badge bg-danger">{{ $offense->offense }}</span>
                        </p>
                        <p class="text-muted mb-2">{{ $offense->remarks ?? '-' }}</p>
                        <small class="text-muted">Date: {{ \Carbon\Carbon::parse($offense->date)->format('M d, Y') }}</small>

                        <!-- Buttons -->
                        <div class="mt-auto d-flex justify-content-between pt-3">
                            <a href="{{ route('counselor.offenses.edit', $offense->id) }}"
                               class="btn btn-warning btn-sm btn-custom">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('counselor.offenses.destroy', $offense->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this offense?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-custom">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center text-muted">
                    No offenses recorded yet.
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Simple Search --}}
<script>
    const searchInput = document.getElementById('searchOffense');
    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('.card').forEach(card => {
            const text = card.innerText.toLowerCase();
            card.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection
