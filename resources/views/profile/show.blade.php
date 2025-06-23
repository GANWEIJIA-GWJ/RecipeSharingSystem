@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body text-center">
                <!-- Display user's avatar -->
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="img-thumbnail profile-avatar">
                @else
                    <img src="{{ asset('storage/images/default-avatar.jpg') }}" alt="Default Avatar"
                        class="img-thumbnail profile-avatar">
                @endif


                <!-- Display user's name -->
                <h3 class="mt-3">{{ $user->name }}</h3>

                <!-- Display user's email -->
                <p>Email: {{ $user->email }}</p>

                <!-- Display user'role -->
                <p>Account Type: {{ $user->role }}</p>

                <!-- Display user's bio -->
                <p>Bio: {{ $user->bio ?? 'No bio provided.' }}</p>

                <!-- Display registration date -->
                <p>Member since: {{ $user->created_at->format('F d, Y') }}</p>

                <!-- Button to edit personal information -->
                <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-2">Edit Profile</a>
            </div>
        </div>

        <!-- New Section: Update Credentials (Email & Password) -->
        <div class="card mt-4">
            <div class="card-body text-center">
                <h4 class="card-title">Update Credentials</h4>
                <p class="card-text">If you want to update your email or password, click the button below.</p>
                <a href="{{ route('profile.editCredentials') }}" class="btn btn-secondary">Update Credentials</a>
            </div>
        </div>

        @can('viewAny', App\Models\Recipe::class)
            <!-- display the user's recipes -->
            @if($recipes->count())
            <div class="mt-4">
                <h4>Your Created Recipes</h4>
                <div class="row">
                    @foreach($recipes as $recipe)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                @if($recipe->photo_url)
                                    <img src="{{ asset('storage/' . $recipe->photo_url) }}" alt="Recipe Image"
                                        class="card-img-top img-fluid">
                                @else
                                    <img src="{{ asset('images/default-recipe.jpg') }}" alt="Default Recipe Image"
                                        class="card-img-top img-fluid">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $recipe->title }}</h5>
                                    <a href="{{ route('recipeDetail', ['id' => $recipe->id]) }}" class="btn btn-info">View
                                        Recipe</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $recipes->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        @endcan

    </div>
@endsection