<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/home', [RecipeController::class, 'showRecipes'])->middleware('auth')->name('home');

Route::get('/recipeDetail/{id}', [RecipeController::class, 'showRecipeDetails'])->name('recipeDetail');

Route::get('/createRecipe', [RecipeController::class, 'showCategories']);
Route::post('/createRecipe', [RecipeController::class, 'store']);

Route::get('/showUpdateRecipe/{id}', [RecipeController::class, 'showUpdateRecipe']);
Route::post('/updateRecipe', [RecipeController::class, 'updateRecipe'])->name('updateRecipe');

Route::delete('/deleteRecipe/{id}', [RecipeController::class, 'deleteRecipe'])->name('deleteRecipe');

Route::post('/categories', [CategoryController::class, 'store'])->name('createCategory');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('updateCategory');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit-credentials', [ProfileController::class, 'editCredentials'])->name('profile.editCredentials');
    Route::post('/profile/update-credentials', [ProfileController::class, 'updateCredentials'])->name('profile.updateCredentials');
    Route::post('/profile/become-recipe-owner', [ProfileController::class, 'becomeRecipeOwner'])
        ->name('profile.becomeRecipeOwner');
});

//GAN WEI JIA work
Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/change-role/{id}', [AdminController::class, 'changeUserRole'])->name('admin.changeRole');
        Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

        Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
        Route::post('/admin/update-user/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

