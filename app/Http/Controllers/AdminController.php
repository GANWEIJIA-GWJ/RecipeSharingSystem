<?php

namespace App\Http\Controllers;
use App\Models\Recipe; // Import Recipe model
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::paginate(10, ['*'], 'users_page');
        $recipes = Recipe::paginate(10, ['*'], 'recipes_page');
        $categories = Category::paginate(4, ['*'], 'categories_page');
    
        return view('admin.dashboard', compact('users', 'recipes', 'categories'));
    }
    
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    public function changeUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User role updated!');
    }
    
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'role' => 'required|in:user,recipeOwner,admin',
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'User updated successfully!');
    }

}
