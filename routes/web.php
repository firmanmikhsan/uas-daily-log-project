<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\JobPositionController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', "middleware" => "auth"], function(){
    Route::get('/', DashboardController::class)->name('index');
    Route::resources([
        'users' => UserController::class,
        'projects' => ProjectController::class,
        'roles' => RoleController::class,
        'permissions' => PermissionController::class,
        'positions' => JobPositionController::class,
    ]);
});
