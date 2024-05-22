<?php

use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->group(function (){
    //retourne le user actuellement connecter
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/get_students',[\App\Http\Controllers\StudentController::class,'index'])->name('index');

    Route::get('/getAllclasses',[\App\Http\Controllers\SchoolClassController::class,'index']);

    Route::post('/add_student',[\App\Http\Controllers\StudentController::class,'store']);

    Route::get('/deletestudent/{id}',[\App\Http\Controllers\StudentController::class,'destroy']);

    Route::get('/editstudent/{id}',[\App\Http\Controllers\StudentController::class,'edit']);

    Route::post('/update_student/{id}',[\App\Http\Controllers\StudentController::class,'update']);

    Route::post('/register',[UserController::class,'register']);



    Route::get('/all_users',[UserController::class,'all_users']);

});
Route::post('/login',[UserController::class,'login']);
Route::post('/logout', [UserController::class, 'logout']);


