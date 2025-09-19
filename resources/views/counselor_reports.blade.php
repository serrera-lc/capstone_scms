@extends('layoutc')

@section('content')
<div class="container py-5">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#d63384;">Reports</h2>
            <p class="text-muted mb-0">Overview of counseling sessions, appointments, and offenses.</p>
        </div>
    </div>

    {{-- Reports Table --}}
    <div class="card shadow-sm rounded-3" style="background-color:#ffe6f0; border:none;">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="color:#d63384;">Generated Reports</h5>
            <form action="{{ route('counselor.reports') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="🔍 Search reports..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary btn-sm" style="background-color:#d63384; border:none;">Search</button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="background-color:white;">
                    <thead style="background-color:#ffd6e8;">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->title ?? 'Untitled Report' }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ ucfirst($report->category ?? 'general') }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y') }}</td>
                                <td>
                                    @if($report->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($report->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('counselor.reports.show', $report->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ route('counselor.reports.download', $report->id) }}" class="btn btn-sm btn-outline-success">Download</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No reports available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $reports->links() }}
    </div>
</div>
@endsection

