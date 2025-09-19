@extends('layoutc')

@section('page-title', 'Student Offenses')

@section('content')
<style>
    /* ===== White + Light Pink Theme ===== */
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
        border-left: 5px solid #f8bbd0;
    }

    .header-container h2 {
        font-weight: 700;
        font-size: 1.6rem;
        color: #c2185b;
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
        border: 1px solid #f8bbd0;
        width: 100%;
        box-shadow: 0 1px 4px rgba(248, 187, 208, 0.6);
        transition: 0.3s;
        background-color: #fff;
    }

    .search-box input:focus {
        border-color: #f48fb1;
        box-shadow: 0 2px 8px rgba(248, 187, 208, 0.8);
        outline: none;
    }

    .search-box i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #c2185b;
    }

    /* Cards */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(248, 187, 208, 0.4);
        transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        background-color: #fff;
        border-top: 4px solid #f8bbd0;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 18px rgba(248, 187, 208, 0.6);
    }

    .card-title {
        font-weight: 600;
        color: #d63384;
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

    .btn-primary {
        background-color: #f8bbd0;
        border: none;
        color: #3c4043;
    }

    .btn-primary:hover {
        background-color: #f48fb1;
        color: #fff;
    }

    .btn-warning {
        background-color: #fce4ec;
        border: none;
        color: #880e4f;
    }

    .btn-warning:hover {
        background-color: #f8bbd0;
        color: #fff;
    }

    .btn-danger {
        background-color: #f48fb1;
        border: none;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #ec407a;
    }

    /* Badges */
    .badge-offense {
        background-color: #fce4ec;
        color: #c2185b;
        font-weight: 500;
        border-radius: 12px;
        padding: 5px 10px;
    }

    /* Empty State */
    .empty-state {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(248, 187, 208, 0.4);
        font-size: 1.1rem;
        border-left: 5px solid #f8bbd0;
    }
</style>

<div class="container my-5">

    <!-- Header + Buttons -->
    <div class="header-container mb-4">
        <h2>📋 Student Offenses</h2>
        <a href="{{ route('counselor.offenses.create') }}" class="btn btn-primary btn-custom shadow-sm">
            <i class="bi bi-plus-circle"></i> Add Offense
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" 
             role="alert" style="border-left:4px solid #f8bbd0;">
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
                            <span class="badge-offense">{{ $offense->offense }}</span>
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
