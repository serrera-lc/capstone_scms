@extends('layout')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">👥 Manage Users</h3>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    {{-- Success/Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add User Form --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="">-- Select Role --</option>
                            <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                            <option value="counselor" {{ old('role')=='counselor' ? 'selected' : '' }}>Counselor</option>
                            <option value="student" {{ old('role')=='student' ? 'selected' : '' }}>Student</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Add User</button>
            </form>
        </div>
    </div>

    {{-- Existing Users Table --}}
    <div class="card shadow-sm">
        <div class="card-header fw-bold">Existing Users</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        @if(auth()->user()->role === 'admin')<th>Action</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            @if(auth()->user()->role === 'admin')
                                <td>
                                    @if(auth()->id() !== $user->id)
                                        {{-- Edit Button --}}
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                            Edit
                                        </button>

                                        {{-- Delete Form --}}
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>

                                        {{-- Edit User Modal --}}
                                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserLabel{{ $user->id }}" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="editUserLabel{{ $user->id }}">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                  @csrf
                                                  @method('PUT')
                                                  <div class="modal-body">
                                                      <div class="mb-3">
                                                          <label class="form-label">Name</label>
                                                          <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                      </div>
                                                      <div class="mb-3">
                                                          <label class="form-label">Email</label>
                                                          <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                      </div>
                                                      <div class="mb-3">
                                                          <label class="form-label">Password (Leave blank to keep current)</label>
                                                          <input type="password" name="password" class="form-control">
                                                      </div>
                                                      <div class="mb-3">
                                                          <label class="form-label">Role</label>
                                                          <select name="role" class="form-select" required>
                                                              <option value="admin" {{ $user->role=='admin' ? 'selected' : '' }}>Admin</option>
                                                              <option value="counselor" {{ $user->role=='counselor' ? 'selected' : '' }}>Counselor</option>
                                                              <option value="student" {{ $user->role=='student' ? 'selected' : '' }}>Student</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                      <button type="submit" class="btn btn-primary">Update User</button>
                                                  </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
