@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="mb-0">Edit Profile</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}"
                            required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Bio Field -->
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea name="bio" id="bio" class="form-control" rows="3">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Avatar Upload -->
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Update Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="form-control">
                        @if($user->avatar)
                            <div class="mt-2">
                                <p class="mb-1">Current Avatar:</p>
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="img-thumbnail"
                                    style="width:150px; height:150px;">
                            </div>
                        @else
                            <p class="mt-2">No avatar uploaded. Using default image.</p>
                        @endif
                        @error('avatar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection