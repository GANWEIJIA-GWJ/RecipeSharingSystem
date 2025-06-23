<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Category;

class RecipeController extends Controller
{
    // Display the form for creating a new recipe
    public function showCategories()
    {
        $categories = Category::all();
        return view('createRecipe', ['categories' => $categories]);
    }

    // Store a new recipe in the database
    public function store(Request $request)
    {
        // Authorize creation (checks RecipePolicy::create)
        $this->authorize('create', Recipe::class);

        $validatedData = $request->validate([
            'title' => 'bail|required|unique:recipes|max:255|regex:/^[A-Za-z\s]+$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|max:500',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|array',
            'ingredients.*' => 'string|required',
            'steps' => 'required|array',
            'steps.*' => 'string|required',
        ]);

        $recipe = new Recipe;
        $recipe->title = $validatedData['title'];
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $recipe->photo_url = $path;
        }
        $recipe->description = $validatedData['description'];
        $recipe->ingredients = $validatedData['ingredients'];
        $recipe->steps = $validatedData['steps'];
        $recipe->category_id = $validatedData['category_id'];
        $recipe->user_id = auth()->id() ?? 1;
        $recipe->save();

        return redirect('/home')->with('success', 'Recipe created successfully');
    }

    // Display a list of recipes with filtering options
    public function showRecipes(Request $request)
    {
        $query = Recipe::with('user');

        if ($request->has('category')) {
            if ($request->category == '') {
                session()->forget('category_filter');
            } else {
                $query->where('category_id', $request->category);
                session(['category_filter' => $request->category]);
            }
        } elseif (session()->has('category_filter')) {
            $query->where('category_id', session('category_filter'));
        }

        if ($request->has('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $recipes = $query->paginate(10);
        $categories = Category::all();

        return view('home', ['recipes' => $recipes, 'categories' => $categories]);
    }

    // Display detailed view of a recipe
    public function showRecipeDetails($id)
    {
        $recipe = Recipe::with(['category', 'user'])->findOrFail($id);
        // Optionally you could authorize viewing here if needed:
        // $this->authorize('view', $recipe);
        return view('recipeDetail', ['recipe' => $recipe]);
    }

    // Display the form to update a recipe
    public function showUpdateRecipe($id)
    {
        $recipe = Recipe::find($id);
        $categories = Category::all();
        return view('showUpdateRecipe', ['recipe' => $recipe, 'categories' => $categories]);
    }

    // Update an existing recipe
    public function updateRecipe(Request $request)
    {
        $recipe = Recipe::findOrFail($request->id);

        // Authorize update action (checks RecipePolicy::update)
        $this->authorize('update', $recipe);

        $rules = [];
        if ($request->title !== $recipe->title) {
            $rules['title'] = [
                'required',
                'max:255',
                'regex:/^[A-Za-z\s]+$/',
            ];
        }
        if ($request->description !== $recipe->description) {
            $rules['description'] = 'required|max:500';
        }
        if ($request->category_id !== $recipe->category_id) {
            $rules['category_id'] = 'required|exists:categories,id';
        }
        if ($request->ingredients !== $recipe->ingredients) {
            $rules['ingredients'] = 'required|array';
            $rules['ingredients.*'] = 'string|required';
        }
        if ($request->steps !== $recipe->steps) {
            $rules['steps'] = 'required|array';
            $rules['steps.*'] = 'string|required';
        }

        $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        $validatedData = $request->validate($rules);

        $updateData = [];
        foreach ($validatedData as $key => $value) {
            $updateData[$key] = $value;
        }


        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $updateData['photo_url'] = $path;
        }

        if (!empty($updateData)) {
            $recipe->update($updateData);
        }

        return redirect("/recipeDetail/{$recipe->id}")->with('success', 'Recipe updated successfully!');
    }

    // Delete a recipe
    public function deleteRecipe($id)
    {
        $recipe = Recipe::findOrFail($id);

        // Authorize delete action (checks RecipePolicy::delete)
        $this->authorize('delete', $recipe);

        $recipe->delete();
        return redirect('/home')->with('success', 'Recipe deleted successfully');
    }
}
