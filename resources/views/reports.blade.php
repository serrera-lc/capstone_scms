@extends('layout')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📑 Reports</h3>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h5 class="fw-bold">Total Offenses</h5>
                <p class="fs-3 text-danger">{{ \App\Models\Offense::count() }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h5 class="fw-bold">Students with Offenses</h5>
                <p class="fs-3 text-warning">{{ \App\Models\Offense::distinct('student_id')->count('student_id') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h5 class="fw-bold">Most Recent Offense</h5>
                @php
                    $latestOffense = \App\Models\Offense::latest('date')->first();
                @endphp
                <p class="fs-6">
                    @if($latestOffense)
                        {{ $latestOffense->offense }} <br>
                        <small>{{ \Carbon\Carbon::parse($latestOffense->date)->format('M d, Y') }}</small>
                    @else
                        None
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Offenses Table --}}
    <div class="card shadow-sm">
        <div class="card-header fw-bold">All Offenses</div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Student</th>
                        <th>Offense</th>
                        <th>Remarks</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Offense::with('student')->latest()->get() as $offense)
                        <tr>
                            <td>{{ $offense->student->name ?? 'Unknown' }}</td>
                            <td>{{ $offense->offense }}</td>
                            <td>{{ $offense->remarks ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($offense->date)->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No offenses recorded</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
