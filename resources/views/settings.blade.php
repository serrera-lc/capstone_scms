@extends('layout')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">⚙️ System Settings</h3>

    <div class="card shadow-sm p-4">
        <form>
            {{-- Backup Database --}}
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Backup Database</label>
                <button type="button" class="btn btn-secondary">
                    <i class="bi bi-database-fill-down"></i> Run Backup
                </button>
            </div>

            {{-- Password Protection --}}
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="passwordProtection">
                <label class="form-check-label" for="passwordProtection">Enable Password Protection</label>
            </div>

            {{-- Email Notifications --}}
            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                <label class="form-check-label" for="emailNotifications">Enable Email Notifications</label>
            </div>

            {{-- Save Settings --}}
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Save Settings
            </button>
        </form>
    </div>
</div>
@endsection
