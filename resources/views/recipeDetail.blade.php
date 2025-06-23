<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $recipe->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('layouts.app')
    @section('content')

        <div class="container mt-4">
            <h1 class="text-center">{{ $recipe->title }}</h1>
            <p class="text-muted text-center"><strong>Category:</strong> {{ $recipe->category->name }}</p>

            <hr>

            <!-- Image -->
            @if($recipe->photo_url)
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/' . $recipe->photo_url) }}" alt="Recipe Image"
                        style="max-width: 30%; height: auto;">
                </div>
            @else
                <div class="mb-3 text-center">
                    <img src="{{ asset('images/default-recipe.jpg') }}" alt="Default Recipe Image"
                        style="max-width: 30%; height: auto;">
                </div>
            @endif

            <hr>

            <!-- Recipe Description -->
            <h3>Description:</h3>
            <p class="lead">{{ $recipe->description }}</p>

            <hr>

            <!-- Ingredients -->
            <h3>Ingredients:</h3>
            <ul class="list-group">
                @foreach($recipe->ingredients as $ingredient)
                    <li class="list-group-item">{{ $ingredient }}</li>
                @endforeach
            </ul>

            <hr>

            <!-- Cooking Steps -->
            <h3>Steps:</h3>
            <ol class="list-group list-group-numbered">
                @foreach($recipe->steps as $step)
                    <li class="list-group-item">{{ $step }}</li>
                @endforeach
            </ol>

            <hr>

            <!-- Edit & Delete Buttons -->
            <div class="d-flex">
                @can('delete', $recipe)
                    <!-- Delete Button -->
                    <form action="{{ url('/deleteRecipe/' . $recipe->id) }}" method="POST" class="me-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100"
                            style="width: 100px; height: 30px; display:flex; align-items: center"
                            onclick="return confirm('Are you sure you want to delete this recipe?');">
                            Delete
                        </button>
                    </form>
                @endcan

                @can('update', $recipe)
                    <!-- Edit Button -->
                    <a href="{{ url('/showUpdateRecipe/' . $recipe->id) }}" class="btn btn-warning w-50px h-100px"
                        style="width: 55px; height: 30px; display:flex; align-items: center">
                        Edit
                    </a>
                @endcan

                @unless(auth()->check())
                    <!-- If not logged in or not the author/admin, show login buttons-->
                    <a href="{{ url('/login') }}" class="btn btn-secondary"
                        style="width: 200px; height: 30px; display: flex; align-items: center; justify-content: center;">
                        Login to Edit or Delete
                    </a>
                @endunless
            </div>

            <hr>

            <!-- Back to Home Button -->
            <div class="text-center">
                <a href="{{ url('/home') }}" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>

    @endsection

</body>