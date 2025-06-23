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
        <h2 class="text-center mb-4">Edit Recipe</h2>
        <form action="/updateRecipe" method="post" class="p-4 border rounded bg-light" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $recipe->id }}">

            <!-- Recipe Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Recipe Title:</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $recipe->title) }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Recipe Image -->
            <div class="form-group mb-3">
                <label for="image">Update Recipe Image</label>
                <input type="file" name="image" id="image" class="form-control-file">
                @if($recipe->photo_url)
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/' . $recipe->photo_url) }}" alt="Current Recipe Image"
                        style="max-width: 200px;">
                @endif
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Recipe Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Recipe Description:</label>
                <input type="text" class="form-control" id="description" name="description"
                    value="{{ old('description', $recipe->description) }}" required>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="" hidden>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $recipe->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Ingredients -->
            <div class="mb-3">
                <label class="form-label">Ingredients:</label>
                <div id="ingredientsList">
                    @foreach(old('ingredients', $recipe->ingredients) as $ingredient)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="ingredients[]" value="{{ $ingredient }}" required>
                        </div>
                    @endforeach
                </div>
                @error("ingredients.*")
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <button type="button" class="btn btn-outline-primary mt-2" onclick="addIngredient()">+ Add
                    Ingredient</button>
            </div>

            <!-- Instructions -->
            <div class="mb-3">
                <label class="form-label">Instructions:</label>
                <div id="instructions">
                    @foreach(old('steps', $recipe->steps) as $step)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="steps[]" value="{{ $step }}" required>
                        </div>
                    @endforeach
                </div>
                @error('steps.*')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <button type="button" class="btn btn-outline-primary mt-2" onclick="addInstruction()">+ Add
                    Instruction</button>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

    <script>
        function addIngredient() {
            const ingredientsDiv = document.getElementById("ingredientsList");
            const inputGroup = document.createElement("div");
            inputGroup.classList.add("input-group", "mb-2");

            const newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = "ingredients[]";
            newInput.classList.add("form-control");
            newInput.placeholder = "Enter ingredient";

            inputGroup.appendChild(newInput);
            ingredientsDiv.appendChild(inputGroup);
        }

        function addInstruction() {
            const instructionDiv = document.getElementById("instructions");
            const inputGroup = document.createElement("div");
            inputGroup.classList.add("input-group", "mb-2");

            const newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = "steps[]";
            newInput.classList.add("form-control");
            newInput.placeholder = "Enter instruction";

            inputGroup.appendChild(newInput);
            instructionDiv.appendChild(inputGroup);
        }

    </script>
    @endsection
</body>