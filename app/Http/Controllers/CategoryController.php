<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function store(Request $request) {
        $validated = $request->validate([
            'new_name' => 'required|string|max:255|unique:categories,name',
        ]);
    
        $capitalizedName = ucfirst(strtolower($validated['new_name']));
        
        Category::create(['name' => $capitalizedName]);
        return redirect()->back()->with('success', 'Category added successfully!');
    }
    
    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
    
        $fieldName = 'name_' . $id;

        $validated = $request->validate([
            $fieldName => 'required|string|max:255|unique:categories,name,' . $id,
        ], [
            $fieldName . '.unique' => 'The name has already been taken.',
        ]);

        $capitalizedName = ucfirst(strtolower($validated[$fieldName]));
    
        $category->update(['name' => $capitalizedName]);
        return redirect()->back()->with('success', 'Category updated successfully!');
    }
    
    public function destroy($id) {
        $category = Category::findOrFail($id);
        if ($category->recipes()->count()) {
            return redirect()->back()->with('error', 'Cannot delete category that has recipes.');
        }
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
    
}
