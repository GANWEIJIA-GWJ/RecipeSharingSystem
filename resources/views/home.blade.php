<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('layouts.app')
    @section('content')

        <div class="container mt-4">
            <h1 class="text-center">Welcome to RecipeHUB</h1>
            <br>
            <h2>Recipe List</h2>

            <!-- Search & Category Filter -->
            <form method="GET" action="{{ url('/home') }}" class="d-flex mb-4" id="filterForm">
                <!-- Search Input -->
                <input type="text" name="search" class="form-control me-2" placeholder="Search Recipe..."
                    value="{{ request('search') }}" id="searchInput">

                <!-- Category Dropdown -->
                <select name="category" class="form-select me-2" id="categorySelect">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (request('category') == $category->id || session('category_filter') == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Search Button (Optional) -->
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <script>
                // Debounce function to delay form submission
                let debounceTimeout;

                // Update form on category change
                document.getElementById('categorySelect').addEventListener('change', function () {
                    document.getElementById('filterForm').submit();
                });

                // Update form on search input change, with a debounce effect
                document.getElementById('searchInput').addEventListener('input', function () {
                    clearTimeout(debounceTimeout); // Clear the previous timeout

                    debounceTimeout = setTimeout(function () {
                        document.getElementById('filterForm').submit(); // Submit the form after the user stops typing
                    }, 1000); // Adjust delay in milliseconds (1000ms is 1 seconds)
                });
            </script>

            <!-- Create Recipe & Login Button -->
            <div class="mb-3">
                @can('create', App\Models\Recipe::class)
                    <a href="{{ url('/createRecipe') }}" class="btn btn-success">Create Recipe</a>
                @else
                    @if(!auth()->check())
                        <a href="{{ url('/login') }}" class="btn btn-secondary">Login</a>
                    @endif
                @endcan
            </div>

            <!-- Become Recipe Owner (for normal users) -->
            @auth
                @if(Auth::user()->role === 'user')
                    <div class="alert alert-info">
                        <p>Do you want to become a Recipe Owner and gain the ability to create recipes?</p>
                        <form action="{{ route('profile.becomeRecipeOwner') }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to become a Recipe Owner?');">
                            @csrf
                            <button type="submit" class="btn btn-warning">Become Recipe Owner</button>
                        </form>
                    </div>
                @endif
            @endauth

            <!-- Display All Recipes -->
            <div class="row">
                @foreach($recipes as $recipe)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if($recipe->photo_url)
                                <img src="{{ asset('storage/' . $recipe->photo_url) }}" alt="Recipe Image"
                                    class="card-img-top img-fluid">
                            @else
                                <img src="{{ asset('images/default-recipe.jpg') }}" alt="Default Recipe Image"
                                    class="card-img-top img-fluid">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $recipe->title }}</h5>
                                <p class="card-text"><strong>Category:</strong> {{ $recipe->category->name }}</p>
                                <p class="card-text"><small>Created by: {{ $recipe->user->name ?? 'Unknown' }}</small></p>
                                <div class="mt-auto text-center">
                                    <a href="{{ route('recipeDetail', ['id' => $recipe->id]) }}" class="btn btn-info">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $recipes->links('pagination::bootstrap-4') }}
            </div>
        </div>

    @endsection
</body>