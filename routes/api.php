<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SocialNetworkController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::resource('/users', UserController::class)->middleware('auth:sanctum');
Route::resource('/projects', ProjectController::class)->middleware('auth:sanctum');
Route::resource('/educations', EducationController::class)->middleware('auth:sanctum');
Route::resource('/experiences', ExperienceController::class)->middleware('auth:sanctum');
Route::resource('/languages', LanguageController::class)->middleware('auth:sanctum');
Route::resource('/skills', SkillController::class)->middleware('auth:sanctum');
Route::resource('/social_networks', SocialNetworkController::class)->middleware('auth:sanctum');
Route::resource('/skills', SkillController::class)->middleware('auth:sanctum');
Route::resource('/languages', LanguageController::class)->middleware('auth:sanctum');
Route::resource('/socialNetworks', SocialNetworkController::class)->middleware('auth:sanctum');
Route::resource('/experiences', ExperienceController::class)->middleware('auth:sanctum');
