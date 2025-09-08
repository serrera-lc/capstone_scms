@extends('clean')

@section('page-title', 'Student Feedbacks')

@section('content')
<div class="container py-5">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">📣 Student Feedbacks</h2>
            <p class="text-muted mb-0">View, filter, and manage all submitted student feedback.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary rounded-pill shadow-sm px-4">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>

    {{-- Feedback Table Card --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">📋 All Feedbacks</h5>
            <div class="d-flex gap-2 flex-wrap">
                <input type="text" id="searchInput" class="form-control form-control-sm rounded-pill shadow-sm" placeholder="🔍 Search..." />
                <select id="filterRating" class="form-select form-select-sm rounded-pill shadow-sm">
                    <option value="">All Ratings</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
                <button class="btn btn-sm btn-outline-success rounded-pill shadow-sm" id="exportCSV">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                </button>
                <button class="btn btn-sm btn-outline-danger rounded-pill shadow-sm" id="exportPDF">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill shadow-sm" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="feedbacksTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Counselor</th>
                            <th>Feedback</th>
                            <th>Rating</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $fb)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $fb->student->name ?? 'N/A' }}</td>
                            <td>{{ $fb->counselor->name ?? 'N/A' }}</td>
                            <td>{{ Str::limit($fb->feedback, 50) }}</td>
                            <td>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                    {{ $fb->rating ?? 'N/A' }} ⭐
                                </span>
                            </td>
                            <td>{{ $fb->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No feedbacks found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    const table = $('#feedbacksTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        info: false,
        autoWidth: false
    });

    const searchInput = $('#searchInput');
    const filterRating = $('#filterRating');

    function filterTable() {
        let query = searchInput.val().toLowerCase();
        let rating = filterRating.val();
        table.rows().every(function() {
            const data = this.data();
            const matchesQuery = data.join(' ').toLowerCase().includes(query);
            const matchesRating = !rating || data[4].includes(rating);
            this.node().style.display = (matchesQuery && matchesRating) ? '' : 'none';
        });
    }

    searchInput.on('keyup', filterTable);
    filterRating.on('change', filterTable);

    // Export CSV
    $('#exportCSV').on('click', function() {
        let csv = [];
        $('#feedbacksTable tr').each(function() {
            let row = [];
            $(this).find('th, td').each(function() {
                row.push('"' + $(this).text().trim() + '"');
            });
            csv.push(row.join(','));
        });
        let blob = new Blob([csv.join('\n')], { type: 'text/csv' });
        let link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = "feedbacks.csv";
        link.click();
    });

    // Export PDF
    $('#exportPDF').on('click', function() {
        window.print();
    });
});
</script>

{{-- Styles --}}
<style>
.card {
    border-radius: 16px;
    transition: all 0.2s ease-in-out;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}
.table th {
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}
.badge {
    font-size: 0.85rem;
}
</style>
@endsection
