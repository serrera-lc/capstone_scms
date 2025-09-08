<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Users Management</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Roboto', sans-serif;
    }

    /* Title Section */
    .page-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .page-title h3 {
      font-weight: 700;
      font-size: 24px;
      color: #1a73e8;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .page-title .btn {
      border-radius: 30px;
      font-weight: 500;
      padding: 7px 18px;
      transition: 0.2s ease-in-out;
    }

    .page-title .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }

    /* Card Styling */
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
      padding: 25px;
      background: #fff;
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: translateY(-3px);
    }

    /* Search + Filter Row */
    .search-bar {
      max-width: 280px;
      border-radius: 50px;
      padding: 10px 18px;
      border: 1px solid #dadce0;
      background: #fff;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    .form-select {
      border-radius: 50px;
      padding: 8px 14px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    /* Table Styling */
    .table {
      border-radius: 16px;
      overflow: hidden;
      background-color: white;
    }

    .table th {
      background-color: #f1f3f4;
      color: #5f6368;
      font-weight: 600;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.4px;
      padding: 12px;
    }

    .table tbody tr {
      transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
      background-color: #e8f0fe;
    }

    /* Avatars */
    .user-avatar {
      width: 40px;
      height: 40px;
      background-color: #1a73e8;
      color: #fff;
      font-weight: 600;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right: 10px;
      font-size: 16px;
    }

    /* Role Badges */
    .badge-role {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
      color: white;
    }

    .badge-student { background: #34a853; }
    .badge-counselor { background: #fbbc04; color: #202124; }
    .badge-admin { background: #ea4335; }

    /* Action Buttons */
    .btn-action {
      border-radius: 50%;
      width: 38px;
      height: 38px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: 0.2s ease-in-out;
    }

    .btn-action:hover {
      transform: scale(1.08);
    }

    /* Modal Styling */
    .modal-content {
      border-radius: 16px;
      border: none;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
      border-bottom: none;
    }

    .modal-title {
      font-weight: 600;
      color: #202124;
    }

    .modal-footer {
      border-top: none;
    }
  </style>
</head>
<body>

<div class="container mt-4">
  
  <!-- Page Title -->
  <div class="page-title">
    <h3><i class="bi bi-people-fill"></i> Users Management</h3>
    <div>
      <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus"></i> Add User
      </button>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary rounded-pill shadow-sm px-4">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>
  </div>

  <!-- Flash Messages -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mt-2">
      <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Main Card -->
  <div class="card">
    <div class="d-flex justify-content-between mb-3">
      <input type="text" id="searchInput" class="form-control search-bar" placeholder="🔍 Search users...">
      <select id="filterRole" class="form-select w-auto rounded-pill">
        <option value="">All Roles</option>
        <option value="student">Student</option>
        <option value="counselor">Counselor</option>
        <option value="admin">Admin</option>
      </select>
    </div>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-hover align-middle" id="usersTable">
        <thead>
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Email</th>
            <th>Role</th>
            <th>Grade Level</th>
            <th>Strand</th>
            <th>Created</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                {{ $user->name }}
              </div>
            </td>
            <td>{{ $user->email }}</td>
            <td>
              @if($user->role === 'student')
                <span class="badge-role badge-student">Student</span>
              @elseif($user->role === 'counselor')
                <span class="badge-role badge-counselor">Counselor</span>
              @elseif($user->role === 'admin')
                <span class="badge-role badge-admin">Admin</span>
              @endif
            </td>
            <td>{{ $user->grade_level ?? '-' }}</td>
            <td>{{ $user->strand ?? '-' }}</td>
            <td>{{ $user->created_at->format('M d, Y') }}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-primary btn-action" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" title="Edit">
                <i class="bi bi-pencil"></i>
              </button>
              <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger btn-action" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>

          <!-- Edit User Modal -->
          <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content p-3">
                <div class="modal-header">
                  <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
                    <div class="mb-3"><label class="form-label">Role</label>
                      <select name="role" class="form-select" required>
                        <option value="student" @if($user->role==='student') selected @endif>Student</option>
                        <option value="counselor" @if($user->role==='counselor') selected @endif>Counselor</option>
                        <option value="admin" @if($user->role==='admin') selected @endif>Admin</option>
                      </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Grade Level</label>
                      <select name="grade_level" class="form-select">
                        <option value="" @if(!$user->grade_level) selected @endif>N/A</option>
                        <option value="11" @if($user->grade_level==='11') selected @endif>Grade 11</option>
                        <option value="12" @if($user->grade_level==='12') selected @endif>Grade 12</option>
                      </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Strand</label>
                      <select name="strand" class="form-select">
                        <option value="" @if(!$user->strand) selected @endif>N/A</option>
                        <option value="STEM" @if($user->strand==='STEM') selected @endif>STEM</option>
                        <option value="ABM" @if($user->strand==='ABM') selected @endif>ABM</option>
                        <option value="HUMSS" @if($user->strand==='HUMSS') selected @endif>HUMSS</option>
                        <option value="GAS" @if($user->strand==='GAS') selected @endif>GAS</option>
                        <option value="TVL" @if($user->strand==='TVL') selected @endif>TVL</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-person-plus"></i> Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Full Name</label><input type="text" name="name" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Role</label>
            <select name="role" class="form-select" required>
              <option value="student">Student</option>
              <option value="counselor">Counselor</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="mb-3"><label class="form-label">Grade Level</label>
            <select name="grade_level" class="form-select">
              <option value="">N/A</option>
              <option value="11">Grade 11</option>
              <option value="12">Grade 12</option>
            </select>
          </div>
          <div class="mb-3"><label class="form-label">Strand</label>
            <select name="strand" class="form-select">
              <option value="">N/A</option>
              <option value="STEM">STEM</option>
              <option value="ABM">ABM</option>
              <option value="HUMSS">HUMSS</option>
              <option value="GAS">GAS</option>
              <option value="TVL">TVL</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  let table = $('#usersTable').DataTable({
    paging: true,
    info: true,
    searching: true,
    language: { search: "" }
  });

  $('#filterRole').on('change', function() {
    table.column(3).search(this.value).draw();
  });

  $('#searchInput').on('keyup', function() {
    table.search(this.value).draw();
  });
</script>
</body>
</html>
