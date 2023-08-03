<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    // to look up sql queries performed when the page loads
    // \Illuminate\Support\Facades\DB::listen(function ($query) {
    //     logger($query->sql, $query->bindings);
    // });
    
    // as soon as we perform a query, get the results
    return view('posts', [
        'posts' => Post::latest()->get(),
        'categories' => Category::all()
    ]);

})->name('home');


// route binding key to an eloquent model, wild card name has to match the function parameter
// inject models instances into your routes and controllers, automatically find the id specified in route url
// 'post/{post:slug}' if you want to find the slug that match the route parameter Post::where('slug', $post)->firstOrFail()
Route::get('posts/{post}', function (Post $post) {
    return view('post', [
        'post' => $post
    ]);
    
});

Route::get('categories/{category:slug}', function (Category $category) {
    return view('posts', [
        'posts' => $category->posts,
        'currentCategory' => $category,
        'categories' => Category::all()
    ]);
})->name('category');

Route::get('authors/{author:username}', function (User $author) {
    return view('posts', [
        'posts' => $author->posts,
        'categories' => Category::all()
    ]);
});
