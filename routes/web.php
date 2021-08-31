<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::redirect('/', '/users');
Route::get('users', [UserController::class, 'index']);
Route::any('users/create', [UserController::class, 'create'])
	->middleware('validate.user');
Route::any('users/{user}/edit', [UserController::class, 'edit'])
	->middleware('ensure.entity.exists')
	->middleware('validate.user');
Route::delete('users/{user}', [UserController::class, 'destroy'])
	->middleware('ensure.entity.exists');