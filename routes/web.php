<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\TagController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;


//tag controller and all tag routes
//Route::post('app/create_tag',[TagController::class, 'Test'] );
Route::post('app/create_tag',[TagController::class, 'addTag'] );
Route::get('app/allTag', [TagController::class, 'allTag']);
Route::post('app/edit-tag', [TagController::class, 'editTag']);
Route::post('app/delete-tag', [TagController::class, 'deleteTag']);


//category controller and all category routes
Route::post('/app/category-image/upload',[CategoryController::class, 'uploadImage']);
Route::post('app/category/delete-image', [CategoryController::class, 'deleteImage']);
Route::post('/app/add-category', [CategoryController::class, 'addCategory']);
Route::get('/app/all-category', [CategoryController::class, 'allCategory']);
Route::post('app/delete-category', [CategoryController::class, 'deleteCategory']);
Route::post('app/update-cateogry', [CategoryController::class, 'updateCategory']);

//users controller and all user routes
Route::get('/app/all-user', [UserController::class, 'index']);
Route::post('/app/create-user', [UserController::class, 'createUser']);

Route::get('/', function (){
   return view('welcome');
});

Route::any('{slug}', function(){
   return view('welcome');
});




//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
