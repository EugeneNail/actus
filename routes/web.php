<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/signup', [AuthController::class, "register"])->name('auth.register');
Route::post('/signup', [AuthController::class, "store"])->name('auth.store');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('collections')->name('collections.')->group(function () {
        Route::get('/', [CollectionController::class, 'index'])->name('index');
        Route::get('/new', [CollectionController::class, 'create'])->name('create');
        Route::post('/', [CollectionController::class, 'store'])->name('store');
        Route::get('/{collection}', [CollectionController::class, 'edit'])->name('edit');
        Route::put('/{collection}', [CollectionController::class, 'update'])->name('update');
        Route::get('/{collection}/delete', [CollectionController::class, 'delete'])->name('delete');
        Route::delete('/{collection}', [CollectionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('collections/{collection}/activities')->name('activities.')->group(function () {
        Route::get('/new', [ActivityController::class, 'create'])->name('create');
        Route::post('/', [ActivityController::class, 'store'])->name('store');
        Route::get('/{activity}', [ActivityController::class, 'edit'])->name('edit');
        Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
        Route::get('/{activity}/delete', [ActivityController::class, 'delete'])->name('delete');
        Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('entries')->name('entries.')->group(function () {
        Route::get('/', [EntryController::class, 'index'])->name('index');
        Route::get("/new", [EntryController::class, 'create'])->name('create');
        Route::post('/', [EntryController::class, 'store'])->name('store');
    });
});
