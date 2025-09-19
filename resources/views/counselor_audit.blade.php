@extends('layoutc')

@section('content')
<div class="container py-5">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#d63384;">Audit Logs</h2>
            <p class="text-muted mb-0">Track all actions and changes within the system</p>
        </div>
    </div>

    {{-- Audit Logs Table --}}
    <div class="card shadow-sm rounded-4" style="background-color:#ffe6f0; border:none;">
        <div class="card-body">
            <h5 class="fw-bold mb-3" style="color:#d63384;">System Activity</h5>

            @if($audits->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="background-color:white;">
                        <thead style="background-color:#ffd6e8;">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Module</th>
                                <th>Old Values</th>
                                <th>New Values</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($audits as $audit)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $audit->user->name ?? 'System' }}
                                        <br>
                                        <small class="text-muted">{{ $audit->user->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color:#ffb3c6; color:#000;">
                                            {{ ucfirst($audit->event) }}
                                        </span>
                                    </td>
                                    <td>{{ $audit->auditable_type }}</td>
                                    <td>
                                        <pre class="small bg-light p-2 rounded">{{ json_encode($audit->old_values, JSON_PRETTY_PRINT) }}</pre>
                                    </td>
                                    <td>
                                        <pre class="small bg-light p-2 rounded">{{ json_encode($audit->new_values, JSON_PRETTY_PRINT) }}</pre>
                                    </td>
                                    <td>{{ $audit->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No audit logs found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
