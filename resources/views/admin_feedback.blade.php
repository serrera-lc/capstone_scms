@extends('layout')

@section('page-title', 'Feedback Management')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-dark">Student Feedback</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm" style="background-color: #fff;">
        <div class="card-body">
            <table class="table table-bordered text-center align-middle" style="background-color: #fff;">
                <thead style="background-color: #f8bbd0; color: #880e4f;">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Course & Year</th>
                        <th>Counselor</th>
                        <th>Purpose</th>
                        <th>Likes</th>
                        <th>Suggestions</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $index => $feedback)
                        <tr style="background-color: #fff;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $feedback->name }}</td>
                            <td>{{ $feedback->course_year }}</td>
                            <td>{{ $feedback->counselor }}</td>
                            <td>
                                @if(is_array($feedback->purpose))
                                    <ul class="mb-0">
                                        @foreach($feedback->purpose as $p)
                                            <li>{{ $p }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $feedback->purpose }}
                                @endif
                            </td>
                            <td>{{ $feedback->like ?? '-' }}</td>
                            <td>{{ $feedback->suggestions ?? '-' }}</td>
                            <td>{{ $feedback->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No feedback submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
