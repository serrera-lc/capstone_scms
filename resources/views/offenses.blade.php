<!-- @extends('layout')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">⚖️ Behavior & Offenses</h3>

    {{-- Add Offense Form --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('offenses.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="student" class="form-label">Student <span class="text-danger">*</span></label>
                        <input type="text" name="student" id="student" class="form-control" placeholder="Enter student name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="offense" class="form-label">Offense / Behavior <span class="text-danger">*</span></label>
                        <input type="text" name="offense" id="offense" class="form-control" placeholder="Enter offense or behavior" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-danger btn-sm mt-3">
                    <i class="bi bi-plus-circle"></i> Add Record
                </button>
            </form>
        </div>
    </div>

    {{-- Offenses Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-danger">
                    <tr>
                        <th>Student</th>
                        <th>Offense</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Example entry --}}
                    <tr>
                        <td>Carlos Lopez</td>
                        <td>Late to class</td>
                        <td>Sept 3</td>
                    </tr>

                    {{-- Dynamic loop example --}}
                    {{-- @foreach($offenses as $offense)
                    <tr>
                        <td>{{ $offense->student->name }}</td>
                        <td>{{ $offense->description }}</td>
                        <td>{{ $offense->date->format('M d, Y') }}</td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection -->
