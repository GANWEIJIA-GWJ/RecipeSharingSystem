<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Users Table -->
        <h2>Manage Users</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-warning"
                                    style="width: 72px; height: 40px; margin-right: 5px">Edit</a>
                                <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <style>
            .w-5 {
                display: none;
            }
        </style>
        <!-- Pagination for Users -->
        <div class="mt-3">
            {{ $users->links() }}
        </div>

        <br><br>

        <!-- Recipes Table -->
        <h2>Manage Recipes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recipes as $recipe)
                    <tr>
                        <td>{{ $recipe->title }}</td>
                        <td>{{ $recipe->category->name ?? 'No Category' }}</td>
                        <td>{{ $recipe->user->name ?? 'Unknown' }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('recipeDetail', $recipe->id) }}" class="btn btn-info"
                                    style="width: 72px; height: 40px; margin-right: 5px">View</a>
                                <a href="{{ url('/showUpdateRecipe/' . $recipe->id)}}" class="btn btn-primary"
                                    style="width: 72px; height: 40px; margin-right: 5px">Edit</a>
                                <form action="{{ route('deleteRecipe', $recipe->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination for Recipes -->
        <div class="mt-3">
            {{ $recipes->links() }}
        </div>

        <br><br>
        <!-- Manage Categories -->
        <h2>Manage Categories</h2>

        <!-- Add New Category Form -->
        <form action="{{ route('createCategory') }}" method="POST" class="mb-3 d-flex align-items-center">
            @csrf
            <div class="flex-grow-1 me-2">
                <input type="text" name="new_name" class="form-control @error('new_name') is-invalid @enderror"
                    value="{{old('new_name')}}" placeholder="Enter new category name" required>
                @error('new_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Add Category</button>
        </form>


        <!-- Categories Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td class="d-flex">
                            <!-- Edit Category -->
                            <form action="{{ route('updateCategory', $category->id) }}" method="POST" class="me-2 d-flex">
                                @csrf
                                @method('PUT')
                                <div class="flex-grow-1 me-2">
                                    <input type="text" name="name_{{$category->id}}"
                                        class="form-control @error('name_' . $category->id) is-invalid @enderror"
                                        value="{{ old('name_' . $category->id, $category->name) }}" required>
                                    @error('name_' . $category->id)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-warning">Update</button>
                            </form>

                            <!-- Delete Category -->
                            <form action="{{ route('deleteCategory', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination for Categories -->
        <div class="mt-3">
            {{ $categories->links() }}
        </div>


    </div>
@endsection