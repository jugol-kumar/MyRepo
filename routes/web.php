<?php
use Illuminate\Support\Facades\Route;


Route::get('/', function (){
   return view('welcome');
});

Route::any('{slug}', function(){
   return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
