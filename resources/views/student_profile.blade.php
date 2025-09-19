@extends('layouts')

@section('page-title', 'My Profile')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4">👤 My Profile</h3>

    <div class="card shadow-sm border-0 p-4">
        <div class="row mb-3">
            <div class="col-md-3 text-center">
                <i class="bi bi-person-circle" style="font-size:80px; color:#d63384;"></i>
            </div>
            <div class="col-md-9">
                <h4>{{ $student->name }}</h4>
                <p class="text-muted">{{ $student->email }}</p>
                <span class="badge bg-pink text-dark">{{ ucfirst($student->role) }}</span>
            </div>
        </div>
        <hr>
        <h6 class="fw-bold">Account Details</h6>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name: {{ $student->name }}</li>
            <li class="list-group-item">Email: {{ $student->email }}</li>
            <li class="list-group-item">Role: {{ ucfirst($student->role) }}</li>
        </ul>
    </div>
</div>

<style>
    .bg-pink {
        background-color: #f8d7e2 !important;
    }
</style>
@endsection
