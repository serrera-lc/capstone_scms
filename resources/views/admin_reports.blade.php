@extends('clean')

@section('page-title', 'Reports Management')

@section('content')
<div class="container py-5">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">📄 Reports Management</h2>
            <p class="text-muted mb-0">Monitor, filter, and manage all student offense reports.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary rounded-pill shadow-sm px-4">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100">
                <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                <h6 class="mt-2 text-muted">Pending Reports</h6>
                <h3 class="fw-bold">{{ $reports->where('status','pending')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100">
                <i class="bi bi-journal-check fs-1 text-info"></i>
                <h6 class="mt-2 text-muted">Reviewed</h6>
                <h3 class="fw-bold">{{ $reports->where('status','reviewed')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100">
                <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                <h6 class="mt-2 text-muted">Resolved</h6>
                <h3 class="fw-bold">{{ $reports->where('status','resolved')->count() }}</h3>
            </div>
        </div>
    </div>

    {{-- Reports Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">📋 All Reports</h5>
            <div class="d-flex gap-2 flex-wrap">
                <input type="text" id="searchInput" class="form-control form-control-sm rounded-pill shadow-sm" placeholder="🔍 Search...">
                <select id="filterStatus" class="form-select form-select-sm rounded-pill shadow-sm">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="resolved">Resolved</option>
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
                <table class="table table-hover align-middle mb-0" id="reportsTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Grade & Strand</th>
                            <th>Offense</th>
                            <th>Remarks</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="#" class="text-decoration-none student-info fw-semibold text-primary"
                                   data-name="{{ $report->student->name ?? 'N/A' }}"
                                   data-grade="{{ $report->student->grade_level ?? 'N/A' }}"
                                   data-strand="{{ $report->student->strand ?? 'N/A' }}">
                                   {{ $report->student->name ?? 'N/A' }}
                                </a>
                            </td>
                            <td>{{ $report->student->grade_level ?? 'N/A' }} - {{ $report->student->strand ?? 'N/A' }}</td>
                            <td>{{ Str::limit($report->offense, 30) }}</td>
                            <td>{{ Str::limit($report->remarks ?? 'N/A', 40) }}</td>
                            <td>
                                <span class="badge px-3 py-2 rounded-pill bg-{{ 
                                    $report->status === 'pending' ? 'warning text-dark' : 
                                    ($report->status === 'reviewed' ? 'info text-dark' : 'success') 
                                }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Student Modal --}}
<div class="modal fade" id="studentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title">👩‍🎓 Student Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="studentName"></span></p>
                <p><strong>Grade Level:</strong> <span id="studentGrade"></span></p>
                <p><strong>Strand:</strong> <span id="studentStrand"></span></p>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const rows = document.querySelectorAll('#reportsTable tbody tr');

    function filterTable() {
        let query = searchInput.value.toLowerCase();
        let status = filterStatus.value.toLowerCase();
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            let statusCell = row.cells[5].innerText.toLowerCase();
            row.style.display = (text.includes(query) && (status === "" || statusCell.includes(status))) ? "" : "none";
        });
    }

    searchInput.addEventListener('keyup', filterTable);
    filterStatus.addEventListener('change', filterTable);

    document.getElementById('exportCSV').addEventListener('click', () => {
        let csv = [];
        document.querySelectorAll('#reportsTable tr').forEach(row => {
            let cols = [...row.querySelectorAll('th,td')].map(col => `"${col.innerText}"`);
            csv.push(cols.join(","));
        });
        let blob = new Blob([csv.join("\n")], { type: 'text/csv' });
        let link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = "reports.csv";
        link.click();
    });

    document.getElementById('exportPDF').addEventListener('click', () => {
        window.print();
    });

    document.querySelectorAll('.student-info').forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault();
            document.getElementById('studentName').innerText = el.dataset.name;
            document.getElementById('studentGrade').innerText = el.dataset.grade;
            document.getElementById('studentStrand').innerText = el.dataset.strand;
            new bootstrap.Modal(document.getElementById('studentModal')).show();
        });
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
