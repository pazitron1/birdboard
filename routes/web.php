<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;

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
    return view('welcome');
});


Route::get('projects/create', [ProjectsController::class, 'create'])->name('projects.create');


Route::group(['middleware' => 'auth'], function () {
    Route::get('projects', [ProjectsController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ProjectsController::class, 'create'])->name('projects.create');
    Route::get('projects/{project}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::post('projects', [ProjectsController::class, 'store'])->name('projects.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
