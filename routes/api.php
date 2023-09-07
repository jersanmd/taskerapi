<?php

use App\Http\Controllers\Api\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/tasks')-> name('tasks.')->group(function() {
    Route::get('/', [TasksController::class, 'index'])->name('index'); 
    Route::post('/store', [TasksController::class, 'store'])->name('store'); 
    Route::patch('/update/{task:uuid}', [TasksController::class, 'update'])->name('update');
    Route::delete('/destroy/{task:uuid}', [TasksController::class, 'destroy'])->name('destroy');
});