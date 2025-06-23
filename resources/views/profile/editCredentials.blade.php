@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="mb-0">Update Credentials</h2>
            </div>
            <div class="card-body">
                <!-- Form for updating email and password -->
                <form action="{{ route('profile.updateCredentials') }}" method="POST">
                    @csrf

                    <!-- Current Password Field -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- New Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">New Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- New Password Field (optional) -->
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password (leave blank if not changing)</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Confirm New Password Field -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update Credentials</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection