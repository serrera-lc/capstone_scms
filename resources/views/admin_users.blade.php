@extends('layout')

@section('content')
<div class="container mt-4">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add User --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold">Add User</div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST" class="row g-2 align-items-center">
                @csrf
                <div class="col">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="col">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col">
                    <select name="role" class="form-select" required>
                        <option value="">Role</option>
                        <option value="admin">Admin</option>
                        <option value="counselor">Counselor</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="col">
                    <select name="grade_level" class="form-select">
                        <option value="">Grade</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" name="strand" class="form-control" placeholder="Strand">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary rounded-circle">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Import CSV --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold">Import Users</div>
        <div class="card-body">
            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
                @csrf
                <div class="col">
                    <input type="file" name="file" class="form-control" accept=".csv" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success rounded-circle">
                        <i class="bi bi-upload"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Search --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold">Search Users</div>
        <div class="card-body">
            <form action="{{ route('admin.users') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by name, email, or strand"
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="student" {{ request('role')=='student' ? 'selected' : '' }}>Students</option>
                        <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admins</option>
                        <option value="counselor" {{ request('role')=='counselor' ? 'selected' : '' }}>Counselors</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary rounded-circle">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary rounded-circle">
                        <i class="bi bi-arrow-repeat"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- User List --}}
    <div class="card shadow-sm">
        <div class="card-header fw-bold">User List</div>
        <div class="card-body table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Grade</th>
                        <th>Strand</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            {{-- Update Form --}}
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <td><input type="text" name="name" class="form-control" value="{{ $user->name }}"></td>
                                <td><input type="email" name="email" class="form-control" value="{{ $user->email }}"></td>
                                <td>
                                    <select name="role" class="form-select">
                                        <option value="admin" {{ $user->role=='admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="counselor" {{ $user->role=='counselor' ? 'selected' : '' }}>Counselor</option>
                                        <option value="student" {{ $user->role=='student' ? 'selected' : '' }}>Student</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="grade_level" class="form-select">
                                        <option value="">N/A</option>
                                        <option value="11" {{ $user->grade_level=='11' ? 'selected' : '' }}>11</option>
                                        <option value="12" {{ $user->grade_level=='12' ? 'selected' : '' }}>12</option>
                                    </select>
                                </td>
                                <td><input type="text" name="strand" class="form-control" value="{{ $user->strand }}"></td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-warning btn-sm rounded-circle me-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                            </form>

                            {{-- Toggle Status Form --}}
                            <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                    class="btn btn-sm rounded-circle {{ $user->status === 'active' ? 'btn-warning' : 'btn-success' }}"
                                    title="{{ $user->status === 'active' ? 'Deactivate User' : 'Activate User' }}"
                                    onclick="return confirm('Are you sure you want to {{ $user->status === 'active' ? 'deactivate' : 'activate' }} this user?')">
                                    <i class="bi {{ $user->status === 'active' ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                                </button>
                            </form>

                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
