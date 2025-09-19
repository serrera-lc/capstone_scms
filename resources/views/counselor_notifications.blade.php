@extends('layoutc')

@section('content')
<div class="container py-5">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#d63384;">Notifications</h2>
            <p class="text-muted mb-0">View all your system and student notifications here</p>
        </div>
    </div>

    {{-- Notifications Table --}}
    <div class="card shadow-sm rounded-4" style="background-color:#ffe6f0; border:none;">
        <div class="card-body">
            <h5 class="fw-bold mb-3" style="color:#d63384;">Recent Notifications</h5>

            @if($notifications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="background-color:white;">
                        <thead style="background-color:#ffd6e8;">
                            <tr>
                                <th>#</th>
                                <th>Message</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notification->message }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($notification->status === 'unread')
                                            <span class="badge" style="background-color:#ffb3c6; color:#000;">Unread</span>
                                        @else
                                            <span class="badge bg-success">Read</span>
                                        @endif
                                    </td>
                                    <td>{{ $notification->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No notifications found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
