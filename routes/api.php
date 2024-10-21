<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::resource('/students', StudentController::class);
Route::resource('/projects', ProjectController::class);
Route::resource('/educations', EducationController::class);
Route::resource('/experiences', ExperienceController::class);
